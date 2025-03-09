import { Routes } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { ProductosComponent } from './productos/productos.component';
import { SupermercadosComponent } from './supermercados/supermercados.component';

export const routes: Routes = [
  { path: 'home', component: HomeComponent },
  { path: 'productos', component: ProductosComponent }, 
  { path: 'supermercado', component: SupermercadosComponent },
  { path: '', redirectTo: 'home', pathMatch: 'full' },
];
