import { Injectable } from "@angular/core";
import { Observable } from "rxjs";
import { HttpClient } from "@angular/common/http";
import { Router } from "@angular/router";

import { NotificationService } from "../shared/messages/notification.service";
import { API } from "../app.api";

@Injectable({
  providedIn: "root",
})
export class ConfiguracaoService {
  constructor(
    private http: HttpClient,
    private notificationService: NotificationService,
    private router: Router
  ) {}

  getDatawareHouse(search?: string): Observable<any[]> {
    return this.http.get<any[]>(`${API}/data-warehouse`);
  }

  getConfiguracaoByIdDataWarehouse(id): Observable<any> {
    return this.http.get<any[]>(`${API}/configuracao/${id}`);
  }

  getInformacoesAtualizacao(id): Observable<any> {
    return this.http.get<any[]>(`${API}/configuracao/info/${id}`);
  }

  update(form, id) {
    return this.http
      .put(`${API}/configuracao/${id}`, form)
      .subscribe((data) => {
        console.log(data);
      });
  }

  notify(msg) {
    this.notificationService.notify(msg);
  }
}
