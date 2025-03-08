import { Routes } from '@angular/router';
import { HomeComponent } from './home/home.component';

export const routes: Routes = [
  { path: '', redirectTo: 'home', pathMatch: 'full' },  //Home por defecto
  { path: 'home', component: HomeComponent },  // Ruta para eñ Home
];
