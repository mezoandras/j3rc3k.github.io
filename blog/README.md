# Starter blog

A posztok a `posts.xlsx` fájlból töltődnek be (első munkalap, első sor = fejléc):

| A | B | C | D | E |
|---|---|---|---|---|
| Dátum | Cím | Szöveg | Kép (opcionális) | Címke (opcionális) |

- **Dátum**: Excel-dátum, vagy szöveg `2024.02.02` formában. A lista automatikusan a legújabbal kezdődik.
- **Szöveg**: bekezdés = sortörés a cellán belül (Alt+Enter).
- **Kép**: fájlnév az `images/` mappából (pl. `post1.jpg`) vagy teljes URL.
- **Címke**: pl. `minimalism` – kattintva szűr.

Új poszt = új sor az Excelben, majd a fájl feltöltése a GitHub repóba.
A poszt linkje az Excel sorszámán alapul (`post.html?id=3`), ezért a meglévő sorokat ne töröld/szúrd be közéjük, ha a régi linkeknek működniük kell – az új posztot az aljára írd.

Beállítások (posztok oldalanként, dátumformátum, fájlnév): az `app.js` tetején, a `CONFIG` részben.

**Fontos:** az oldal webszerverről működik (GitHub Pages). Dupla kattintással megnyitva a böngésző nem engedi beolvasni az Excelt.
