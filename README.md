# Bundesliga Tipspiel
Dies ist ein kleines Tippspiel, das die erste und zweite Bundesliga umfasst. Getippt wird Pro Spiel jeweils um Heimsieg, AUswärtssieg oder Unentschieden.

### Die Regeln
- Getippt wird jedes Spiel der ersten und zweiten Bundesliga.
- Die Spiele können bis zwei Stunden vor Anpfiff getippt werden.
- Getippt wird auf Heimsieg, Auswärtssieg oder Unentschieden.
- Jedes __FALSCH__ getippte Spiel kostet 0,50 €.
- Jedes __NICHT__ getippte Spiel kostet 1,00 €.
- Die Abrechnung erfolgt nach beendigung des aktuellen Spieltages der jeweiligen Bundesliga.

### Hintergrund zu diesem Projekt
Angefangen hat dieses Projekt zum einen aus spaß in unserer Familie. Dabei haben wir uns ein kleines Konto erichtet, mit dem wir ein super Startkapital für ein Urlaub uns zusammen sparen.

Zum anderen, habe ich es auf dem [Laravel](https://laravel.com/) Framework programmiert, da ich dieses lernen wollte. Der Code ist noch nicht 100% ausgereift, wird aber noch mit Updates versehen.

### Installation
```bash
git clone https://github.com/LittleKing205/BundesligaTippspiel.git
cd BundesligaTippspiel
comoser install
cp .env.example .env
php artisan key:generate --force
```
in der Datei .env muss noch die Datenbank verbindungen angepasst werden.
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=root
DB_PASSWORD=
```
Nachdem die Datenbank verbindung hergestellt wurde, im hauptverzeichnis folgendes eingeben
```bash
php artisan migrate --force
php artisan db:seed --class=InstallSeeder
```

### Benachrichtigungs Dienste
Zur Zeit werden folgende Benachrichtigungs dienste unterstützt:
- SMS benachrichtigungen über die APP [Join](https://play.google.com/store/apps/details?id=com.joaomgcd.join&hl=de&gl=US) von [joaomgcd](https://joaoapps.com/)
- Web Push benachrichtigungen via [Firebase](https://firebase.google.com/) (Achtung noch sehr instabil, da der Service Worker noch nicht ausgereift ist)
- Join Benachrichtigungen über die APP [Join](https://play.google.com/store/apps/details?id=com.joaomgcd.join&hl=de&gl=US) von [joaomgcd](https://joaoapps.com/)
Zur einrichtung bitte erstmal in die **.env** datei sehen, dort sind alle Einstellungen für die Keys vorhanden. Demnächst wird es eine ausführliche Dokumentation der Einrichtung zur verfügung stehen.

### Disclaimer
Dieses Projekt steht noch sehr am anfang der Entwicklung. Es wird empfohlen, dieses Tippspiel erst mit dem nchsten Update zu starten. Es ist jedoch jetzt schon verwendbar, man muss legendlich noch manuell einiges einstellen.

### TODOS:
- i18n hinzufügen
- Kassenwart Liste als PDF Export
- Mehrere Tippgemeinschaften
- Registirerungen Abschaltbar machen
- Mehrere Ligen auswählbar machen
- Daten aus mehreren Quellen laden lassen (Anstatt nur OpenLigaDB mit 1. und 2. Bundeliga)
- Spieler Einladungs Funktion
- Kassenwart kann Zahlungen zurücksetzen (Mit Benachrichtigung an User)
- Verbessertes Permission System
- Readme auf Englisch/Deutsch erstellen
- Strafkosten einstellbar machen.
