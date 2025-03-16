import { Component, OnInit } from '@angular/core';
import { ProductosService } from './productos.service';
import { HttpErrorResponse } from '@angular/common/http';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';


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
  imports: [CommonModule, FormsModule],
  templateUrl: './productos.component.html',
  styleUrls: ['./productos.component.scss']
})

export class ProductosComponent implements OnInit {

  productos: any[] = [];
  productosFiltrados: any[] = [];
  terminoBusqueda: string = '';
  currentPage: number = 1;
  totalPages: number = 999;
  itemsPorPagina: number = 30;
  usuarioAutenticado: boolean = false;
  
  constructor(private productosService: ProductosService, private router: Router) {}

  ngOnInit(): void {
    this.verificarSesion();
  }

  verificarSesion() {
    const usuario = localStorage.getItem('usuario');
    
    if (!usuario) {
      this.router.navigate(['/login']); 
    } else {
      this.usuarioAutenticado = true;
      this.cargarProductos();

    }
  }

  cerrarSesion() {
    localStorage.removeItem('usuario'); 
    this.usuarioAutenticado = false;
    this.router.navigate(['/login']);
  }

  cargarProductos() {
    this.productos = []; 
    this.productosFiltrados = [];
    this.currentPage = 1;
    this.cargarPagina(1);
  }
  
  cargarPagina(pagina: number) {
    this.productosService.obtenerProductos(pagina).subscribe({
      next: (data: any) => {
        console.log(`Cargando página ${pagina}:`, data);
  
        this.productos = [...this.productos, ...data.data]; 
        this.productosFiltrados = [...this.productos];
  
        if (pagina < data.last_page) {
          this.cargarPagina(pagina + 1); 
        } else {
          console.log("Todos los productos cargados.");
          this.actualizarPaginacion();
        }
      },
      error: (error) => {
        console.error('Error al obtener productos:', error);
      }
    });
  }
  
  
  
  
  buscar(event?: Event) {
    if (event) {
      event.preventDefault();
    }
  
    const termino = this.terminoBusqueda.trim().toLowerCase();
    console.log("🔍 Buscando:", termino);
  
    if (termino) {
      this.productosFiltrados = this.productos.filter(producto =>
        producto.nombre.toLowerCase().includes(termino) ||
        producto.supermercado.toLowerCase().includes(termino)
      );
    } else {
      this.productosFiltrados = [...this.productos]; 
    }
  
    console.log("✅ Resultados encontrados:", this.productosFiltrados.length);
  
    this.currentPage = 1;
    this.actualizarPaginacion();
  }
  
  
  

  actualizarPaginacion() {
    this.totalPages = Math.ceil(this.productosFiltrados.length / this.itemsPorPagina);
  }
  
  obtenerProductosPaginaActual() {
    const inicio = (this.currentPage - 1) * this.itemsPorPagina;
    return this.productosFiltrados.slice(inicio, inicio + this.itemsPorPagina);
  }
  
  siguientePagina() {
    if (this.currentPage < this.totalPages) {
      this.currentPage++;
    }
  }
  
  anteriorPagina() {
    if (this.currentPage > 1) {
      this.currentPage--;
    }
  }
  
  
}
 