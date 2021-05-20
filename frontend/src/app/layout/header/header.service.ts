import { Injectable } from "@angular/core";
import { Observable } from "rxjs";
import { tap, filter } from "rxjs/operators";
import { HttpClient } from "@angular/common/http";
import { Router, NavigationEnd } from "@angular/router";

import { NotificationService } from "../../shared/messages/notification.service";
import { API } from "./../../app.api";

@Injectable({
  providedIn: "root",
})
export class HeaderService {
  constructor(
    private http: HttpClient,
    private notificationService: NotificationService,
    private router: Router
  ) {}

  getConfigDatabase(type): Observable<any[]> {
    return this.http.get<any[]>(`${API}/config/${type}`);
  }

  saveConfigDatabase(form): Observable<any[]> {
    return this.http.put<any>(`${API}/config/${form.id}`, form);
  }

  update(form, id) {
    return this.http.put(`${API}/orcamento/${id}`, form).subscribe((data) => {
      if (data["response"]) {
        this.notify("Registro Alterado Com Sucesso!");
        this.router.navigate(["/orcamento"]);
      }
    });
  }

  notify(msg) {
    this.notificationService.notify(msg);
  }
  goTo(path: string = "dashboard") {
    this.router.navigate([`/${path}`]);
  }
}
