import { Injectable } from "@angular/core";
import { Observable } from "rxjs";
import { tap, filter } from "rxjs/operators";
import { HttpClient } from "@angular/common/http";
import { Router, NavigationEnd } from "@angular/router";

import { NotificationService } from "../shared/messages/notification.service";
import { API } from "../app.api";

@Injectable({
  providedIn: "root",
})
export class DataWarehouseService {
  constructor(
    private http: HttpClient,
    private notificationService: NotificationService,
    private router: Router
  ) {}

  getAllTables(search?: string): Observable<any[]> {
    return this.http.get<any[]>(`${API}/all/tables`);
  }

  getColumnsByTable(table): Observable<any[]> {
    return this.http.get<any[]>(`${API}/columns/table/${table}`);
  }

  getFKByTable(table): Observable<any[]> {
    return this.http.get<any[]>(`${API}/fk/table/${table}`);
  }
  gerarDataWarehouse(colunas): Observable<any[]> {
    return this.http.post<any[]>(`${API}/data-warehouse`, colunas);
  }

  getformaPagamentoById(id: string): Observable<any[]> {
    return this.http.get<any[]>(`${API}/forma-pagamento/${id}`);
  }

  save(form) {
    return this.http
      .post<any>(`${API}/forma-pagamento`, form)
      .subscribe((data) => {
        if (data["dados"]) {
          this.notify("Registro Inserido Com Sucesso!");
          this.router.navigate(["/config/formapagamento"]);
        }
      });
  }

  update(form, id) {
    return this.http
      .put(`${API}/forma-pagamento/${id}`, form)
      .subscribe((data) => {
        if (data["response"]) {
          this.notify("Registro Alterado Com Sucesso!");
          this.router.navigate(["/config/formapagamento"]);
        }
      });
  }
  inativar(id: string) {
    return this.http.delete(`${API}/forma-pagamento/${id}`);
  }

  notify(msg) {
    this.notificationService.notify(msg);
  }
  goTo(path: string = "depoimento") {
    this.router.navigate([`/${path}`]);
  }
}
