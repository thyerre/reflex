import { Component, OnInit } from "@angular/core";
import { BreadcrumbService } from "./breadcrumb.service";
@Component({
  selector: "app-breadcrumb",
  templateUrl: "./breadcrumb.component.html",
  styleUrls: ["./breadcrumb.component.css"],
})
export class BreadcrumbComponent implements OnInit {
  pagina: any[] = [];

  constructor(private breadcrumbService: BreadcrumbService) {}

  ngOnInit(): void {
    this.breadcrumbService.pagina.subscribe((pagina) =>
      setTimeout(() => (this.pagina = pagina), 0)
    );
  }
}
