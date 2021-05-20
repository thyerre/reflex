import { Injectable, EventEmitter } from "@angular/core";
@Injectable({
  providedIn: "root",
})
export class BreadcrumbService {
  pagina = new EventEmitter<any[]>();

  chosenPagina(pagina: any[]) {
    this.pagina.emit(pagina);
  }
}
