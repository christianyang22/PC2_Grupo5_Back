import { Component, OnInit } from '@angular/core';
import { ProductosService } from './productos.service';
import { HttpErrorResponse } from '@angular/common/http';
import { CommonModule } from '@angular/common';

interface Producto {
  id: number;
  nombre: string;
  link_imagen: string;
  supermercado: string;
  precio: DoubleRange;
}

@Component({
  selector: 'app-productos',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './productos.component.html',
  styleUrls: ['./productos.component.scss']
})

export class ProductosComponent implements OnInit {
  productos: Producto[] = [];
  currentPage: number = 1;
  totalPages: number = 1;

  constructor(private productosService: ProductosService) {}

  ngOnInit(): void {
    this.cargarProductos();
  }

  cargarProductos(): void {
    this.productosService.obtenerProductos(this.currentPage).subscribe({
      next: (data: any) => {
        console.log("Productos cargados:", data);
        this.productos = data.data;
        this.totalPages = data.last_page;
      },
      error: (error: HttpErrorResponse) => {
        console.error('Error al obtener productos:', error.message);
      }
    });
  }

  siguientePagina(): void {
    if (this.currentPage < this.totalPages) {
      this.currentPage++;
      this.cargarProductos();
    }
  }

  anteriorPagina(): void {
    if (this.currentPage > 1) {
      this.currentPage--;
      this.cargarProductos();
    }
  }
}