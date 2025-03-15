import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

interface Producto {
  id: number;
  nombre: string;
  link_imagen: string;
  supermercado: string;
}

@Injectable({
  providedIn: 'root',
})
export class ProductosService {
  private apiUrl = 'http://127.0.0.1:8000/api/products'; // URL de la API en Laravel

  constructor(private http: HttpClient) {}

  obtenerProductos(): Observable<Producto[]> {
    return this.http.get<Producto[]>(this.apiUrl).pipe(
      map(productos => productos.map(producto => {
        // Corregir la URL si el nombre del directorio es incorrecto
        if (producto.link_imagen.includes('product_imaes')) {
          producto.link_imagen = producto.link_imagen.replace('product_imaes', 'product_images');
        }

        // Si la imagen tiene la extensión mal escrita, intenta corregirlo
        if (!producto.link_imagen.endsWith('.jpg') && !producto.link_imagen.endsWith('.png')) {
          producto.link_imagen = producto.link_imagen + '.jpg';
        }

        return producto;
      }))
    );
  }
}