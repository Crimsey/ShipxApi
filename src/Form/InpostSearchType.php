<?php

namespace App\Form;

use App\Form\DataTransformer\CityNameTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Validator\Constraints\StreetPostalCodeDependency;

class InpostSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('street', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'min' => 3,
                        'max' => 64,
                        'minMessage' => 'Ulica musi mieć co najmniej {{ limit }} znaki.',
                        'maxMessage' => 'Ulica nie może mieć więcej niż {{ limit }} znaków.',
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Miasto jest wymagane']),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 64,
                        'minMessage' => 'Miasto musi mieć co najmniej {{ limit }} znaki.',
                        'maxMessage' => 'Miasto nie może mieć więcej niż {{ limit }} znaków.',
                    ]),
                ],
            ])
            ->add('postalCode', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^\d{2}-\d{3}$/',
                        'message' => 'Kod pocztowy musi być w formacie XX-XXX',
                    ]),
                ],
            ]);

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            if (isset($data['postalCode']) && $data['postalCode'] === '01-234') {
                $form->add('name', TextType::class, [
                    'required' => false,
                ]);
            }
        });

        $builder->get('city')->addModelTransformer(new CityNameTransformer());

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'constraints' => [
                new StreetPostalCodeDependency(),
            ],
        ]);
    }
}