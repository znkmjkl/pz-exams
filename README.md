PZ-Exams
========

Projekt realizowany w ramach przedmiotu "Programowanie Zespołowe".

### Nazewnictwo plików ###
Każdy plik powinien zostać utworzony według następujących wytycznych:
* Zaczynać się od dużej litery
* Każde nowe słowo powinno być rozpoczynane od wielkiej litery.
* Nie stosować podkreślników (_)

**Poprawne przykłady:**
* MojaNazwaPliku.php
* MojPlikCss.css
* MojSkryptValidacyjny.js

Błędne przykłady:
* moja_nazwa_pliku.php
* mojSkrypt.js
* mojplikcss.css

### Operacje na bazie danych ###
W celu wykonania operacji na bazie danych należy skorzystać z klasy DatabaseConnector znajdującej się w pliku (lib/Database/DatabaseConnector.php).
Uwaga dostęp do klasy odbywa się wyłącznie poprzez metody statyczne.

**Przykładowy kod:**

*$dbConnection = DatabaseConnector::getConnection();*

### Operacje na bazie danych - Klasy ###
Każda klasa która operuje bezpośrednio na bazie danych powinna być statyczna. 
Co w skrócie oznacza, że każda metoda rozpoczyna się od słówka kluczowego "static".

**Przykładowy deklaracja metody:**

*static public function checkEmail($basicUser)*

Ponadto każda klasa powinna posiadać prywatny konstruktor, w celu eliminacji tworzenia obiektu przez klienta programiste.

**Przykładowy kod:**

*private function __construct() { }*

Aby ujednolicić kod wszystkie funkcję, które bezpośrednio odwołują się do komend SQL powinny zaiwerać je w nazwie. I tak kilka przykładowych nazw: selectUser, insertUser, deleteUser itp.

### Zgłaszanie błędów ###
Jeżeli znaleźliście błąd w kodzie, to zgłoście go używujacą trackera na githubie.

### Przydatne linki ###
* [Styl kodowania (Zend framework)](http://framework.zend.com/manual/1.12/en/coding-standard.coding-style.html)
* [Pivotal Tracker (Zarządzanie Scrumem)](http://www.pivotaltracker.com/)
