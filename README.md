## Zadanie rekrutacyjne

* Instrukcja uruchomienia
Jeśli lokalnie nie mamy komend php/symfony możemy uruchomić komendy:
```
docker compose build --no-cache
docker compose up -d
```
Następne instrukcje wykonywać w kontenerze php (przy czym nawet jeśli symfony serve podpowie 127.0.0.1:8000 to użyć słowa localhost w przeglądarce)

# W celu przetestowania komendy proszę w terminalu projektu wykonać:
```
php bin/console shipx-api:fetch-inpost-points points <nazwa_miasta>
```
np.
```
php bin/console shipx-api:fetch-inpost-points points Krasnystaw
```

* Jeśli chodzi o drugi etap zadania:
Proszę o uruchomienie w terminalu projektu
```
symfony serve
```
następnie do adresu który komenda podpowie dokleić suffix /inpost/search, np.:
http://127.0.0.1:8000/inpost/search

![przykladowe dzialanie](/example.png)

* Komentarz:
* Myślę że przesadziłem z ilością Interfejsów i Abstraktów (cały folder src\Api\Resource),
jak na zadanie przewidziane na ok. godzinę,
ale starałem się jak najciekawiej spełnić warunek - przewidzenie rozbudowy API o kolejne metody/mapowania.


* Spodziewana przykładowa odpowiedź komendy wygląda następująco:
```
Dane pobrane pomyślnie!
App\Entity\PointResponse Object
(
    [count:App\Entity\ApiResponse:private] => 12
    [page:App\Entity\ApiResponse:private] => 1
    [totalPages:App\Entity\ApiResponse:private] => 1
    [items:App\Entity\PointResponse:private] => Array
        (
            [0] => App\Entity\InpostPoint Object
                (
                    [name:App\Entity\InpostPoint:private] => KSW01APP
                    [address:App\Entity\InpostPoint:private] => App\Entity\Address Object
                        (
                            [line1:App\Entity\Address:private] => Polewana 6
                            [line2:App\Entity\Address:private] => 22-300 Krasnystaw
                        )

                )

            [1] => App\Entity\InpostPoint Object
                (
                    [name:App\Entity\InpostPoint:private] => KSW01M
                    [address:App\Entity\InpostPoint:private] => App\Entity\Address Object
                        (
                            [line1:App\Entity\Address:private] => Królowej Sońki 1
                            [line2:App\Entity\Address:private] => 22-300 Krasnystaw
                        )

                )

            [2] => App\Entity\InpostPoint Object
                (
                    [name:App\Entity\InpostPoint:private] => KSW01N
                    [address:App\Entity\InpostPoint:private] => App\Entity\Address Object
                        (
                            [line1:App\Entity\Address:private] => Kościuszki 13
                            [line2:App\Entity\Address:private] => 22-300 Krasnystaw
                        )

                )

            [3] => App\Entity\InpostPoint Object
                (
                    [name:App\Entity\InpostPoint:private] => KSW02M
                    [address:App\Entity\InpostPoint:private] => App\Entity\Address Object
                        (
                            [line1:App\Entity\Address:private] => Graniczna 2
                            [line2:App\Entity\Address:private] => 22-300 Krasnystaw
                        )

                )

            [4] => App\Entity\InpostPoint Object
                (
                    [name:App\Entity\InpostPoint:private] => KSW04M
                    [address:App\Entity\InpostPoint:private] => App\Entity\Address Object
                        (
                            [line1:App\Entity\Address:private] => Poniatowskiego 15a
                            [line2:App\Entity\Address:private] => 22-300 Krasnystaw
                        )

                )

            [5] => App\Entity\InpostPoint Object
                (
                    [name:App\Entity\InpostPoint:private] => KSW05M
                    [address:App\Entity\InpostPoint:private] => App\Entity\Address Object
                        (
                            [line1:App\Entity\Address:private] => Wysockiej 16
                            [line2:App\Entity\Address:private] => 22-300 Krasnystaw
                        )

                )

            [6] => App\Entity\InpostPoint Object
                (
                    [name:App\Entity\InpostPoint:private] => KSW06M
                    [address:App\Entity\InpostPoint:private] => App\Entity\Address Object
                        (
                            [line1:App\Entity\Address:private] => Sobieskiego 5E
                            [line2:App\Entity\Address:private] => 22-300 Krasnystaw
                        )

                )

            [7] => App\Entity\InpostPoint Object
                (
                    [name:App\Entity\InpostPoint:private] => KSW07M
                    [address:App\Entity\InpostPoint:private] => App\Entity\Address Object
                        (
                            [line1:App\Entity\Address:private] => Krakowskie Przedmieście 39
                            [line2:App\Entity\Address:private] => 22-300 Krasnystaw
                        )

                )

            [8] => App\Entity\InpostPoint Object
                (
                    [name:App\Entity\InpostPoint:private] => KSW08M
                    [address:App\Entity\InpostPoint:private] => App\Entity\Address Object
                        (
                            [line1:App\Entity\Address:private] => Mostowa 35
                            [line2:App\Entity\Address:private] => 22-300 Krasnystaw
                        )

                )

            [9] => App\Entity\InpostPoint Object
                (
                    [name:App\Entity\InpostPoint:private] => KSW09M
                    [address:App\Entity\InpostPoint:private] => App\Entity\Address Object
                        (
                            [line1:App\Entity\Address:private] => Lwowska 49
                            [line2:App\Entity\Address:private] => 22-300 Krasnystaw
                        )

                )

            [10] => App\Entity\InpostPoint Object
                (
                    [name:App\Entity\InpostPoint:private] => POP-KST10
                    [address:App\Entity\InpostPoint:private] => App\Entity\Address Object
                        (
                            [line1:App\Entity\Address:private] => Piłsudskiego 1
                            [line2:App\Entity\Address:private] => 22-300 Krasnystaw
                        )

                )

            [11] => App\Entity\InpostPoint Object
                (
                    [name:App\Entity\InpostPoint:private] => POP-KST9
                    [address:App\Entity\InpostPoint:private] => App\Entity\Address Object
                        (
                            [line1:App\Entity\Address:private] => Zakrecie 2J
                            [line2:App\Entity\Address:private] => 22-300 Krasnystaw
                        )

                )

        )

)
```
