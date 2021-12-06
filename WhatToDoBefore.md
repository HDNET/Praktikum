# Login für den Praktikanten

## Benutzernamen ändern
- Änderungen in folgender Datei durchführen: `/config/packages/security.yaml`
- Änderungen:
    - in Zeile 11 `praktikant` durch praktikantenspezifischen Benutzernamen ändern z.B. Name des Praktikanten

## Password ändern
- Änderungen in folgender Datei durchführen: `/config/packages/security.yaml`
- Änderungen:
  - Mit dem "Hash Password" Command einen Hash generieren:
  - `bin/console security:hash-password` ausführen und ein Password eingeben
  - Password Hash kopieren und in Zeile 11 den 'password' Wert ersetzten
