# Generic Slug Middleware

## Spiegazione
Esempio di come creare un middleware che ti omette il nome delle rotte
```
/pages/dr-jeremy-koepp
/products/prof-andrew-smith-v
/categories/christiana-schuster
```
usando solo lo slug dell'entità
```
/dr-jeremy-koepp
/prof-andrew-smith-v
/christiana-schuster
```
La risoluzione viene fatta in maniera iterativa e la logica è tutta nel middleware
```app/Http/Middleware/CheckSlugType.php```

## Ringraziamenti
Thanks to [Donato Riccio](https://github.com/DonnieRich) per l'dea su come implementare il codice