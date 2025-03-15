import { Component, OnInit } from '@angular/core';
import { ProductosService } from './productos.service';
import { HttpErrorResponse } from '@angular/common/http';
import { CommonModule } from '@angular/common';

interface Producto {
  id: number;
  nombre: string;
  link_imagen: string;  // <- Coincide con el backend
  supermercado: string;
}

@Component({
  selector: 'app-productos',
  standalone: true,
  imports: [CommonModule], // <-- IMPORTANTE: Agregar CommonModule aquí
  templateUrl: './productos.component.html',
  styleUrls: ['./productos.component.scss']
})

export class ProductosComponent implements OnInit {
  productos: Producto[] = [];

  constructor(private productosService: ProductosService) {}

  ngOnInit(): void {
    this.productosService.obtenerProductos().subscribe({
      next: (data: Producto[]) => {
        console.log("Datos recibidos:", data);
        
        // Verifica si data es un array antes de asignarlo
        if (Array.isArray(data)) {
          this.productos = data;
        } else {
          console.error("La API no devolvió un array de productos:", data);
        }
      },
      error: (error: HttpErrorResponse) => {
        console.error('Error al obtener productos:', error.message);
      }
    });
  }
}