// app.routes.ts
import { Routes } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { ProductosComponent } from './productos/productos.component';

export const routes: Routes = [
  // Ruta padre: 'home'
  {
    path: 'home',
    component: HomeComponent,
    children: [
      // Ruta hija: 'home/productos'
      { path: 'productos', component: ProductosComponent },
      // Aquí puedes añadir más rutas hijas
    ]
  },
  { path: '', redirectTo: 'home', pathMatch: 'full' },
];
