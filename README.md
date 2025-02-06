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
App\Entity\InpostPoint Object
(
    [count:App\Entity\InpostPoint:private] => 11
    [page:App\Entity\InpostPoint:private] => 1
    [totalPages:App\Entity\InpostPoint:private] => 1
    [items:App\Entity\InpostPoint:private] => Array
        (
            [0] => Array
                (
                    [name] => KSW01APP
                    [address] => Polewana 6 22-300 Krasnystaw
                )

            [1] => Array
                (
                    [name] => KSW01M
                    [address] => Królowej Sońki 1 22-300 Krasnystaw
                )

            [2] => Array
                (
                    [name] => KSW01N
                    [address] => Kościuszki 13 22-300 Krasnystaw
                )

            [3] => Array
                (
                    [name] => KSW02M
                    [address] => Graniczna 2 22-300 Krasnystaw
                )

            [4] => Array
                (
                    [name] => KSW04M
                    [address] => Poniatowskiego 15a 22-300 Krasnystaw
                )

            [5] => Array
                (
                    [name] => KSW05M
                    [address] => Wysockiej 16 22-300 Krasnystaw
                )

            [6] => Array
                (
                    [name] => KSW06M
                    [address] => Sobieskiego 5E 22-300 Krasnystaw
                )

            [7] => Array
                (
                    [name] => KSW07M
                    [address] => Krakowskie Przedmieście 39 22-300 Krasnystaw
                )

            [8] => Array
                (
                    [name] => KSW08M
                    [address] => Mostowa 35 22-300 Krasnystaw
                )

            [9] => Array
                (
                    [name] => KSW09M
                    [address] => Lwowska 49 22-300 Krasnystaw
                )

            [10] => Array
                (
                    [name] => POP-KST9
                    [address] => Zakrecie 2J 22-300 Krasnystaw
                )

        )

)
```
