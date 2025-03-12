import { Routes } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { ProductosComponent } from './productos/productos.component';
import { SupermercadosComponent } from './supermercados/supermercados.component';
import { PerfilComponent } from './perfil/perfil.component';

export const routes: Routes = [
  { path: 'home', component: HomeComponent },
  { path: 'productos', component: ProductosComponent }, 
  { path: 'supermercados', component: SupermercadosComponent },
  { path: 'perfil', component: PerfilComponent },
  { path: '', redirectTo: 'home', pathMatch: 'full' },
];
