import {
  Component,
  OnInit,
  AfterViewInit,
  AfterContentInit,
} from "@angular/core";
import { LoginService } from "src/app/security/login/login.service";
import { User } from "src/app/security/login/user.model";
import { MenuService } from "./menu.service";
import { API_PATH_IMG } from "./../../app.api";

@Component({
  selector: "app-menu",
  templateUrl: "./menu.component.html",
  styleUrls: ["./menu.component.css"],
})
export class MenuComponent implements OnInit, AfterContentInit, AfterViewInit {
  mostrarMenu: string = "";
  pessoa: User;
  menus: any = [];
  empresa: any[] = [];
  img_logo: string = "assets/img/profile-photos/1.png";
  img_capa: string;

  constructor(
    private loginService: LoginService,
    private menuService: MenuService
  ) {}

  ngAfterContentInit(): void {}
  ngAfterViewInit(): void {}
  ngOnInit() {
    this.userLogado();
    this.getEmpresa();
    this.menu();
  }
  menuOpenOrHide() {
    var element = document.getElementById("container");
    element.classList.remove("mainnav-sm");
    element.classList.add("mainnav-lg");
  }
  userLogado() {
    this.pessoa = this.loginService.getUser();
    if (!this.pessoa) {
      this.loginService.logout();
    }
    if (this.pessoa.img) {
      this.img_logo = API_PATH_IMG + "/funcionario/" + this.pessoa.img;
    }
  }
  menu() {
    this.menuService.getMenu().subscribe((menus) => {
      this.menus = menus;
    });
  }
  getEmpresa() {}

  // menus: Menu[] = [
  //   { icon: "fa-car", name: "Valor da Viagem", url: "vl-viagem" },
  //   { icon: "fa-credit-card-alt", name: "Valor a Cobrar", url: "valorcobrar" },
  //   { icon: "fa-university", name: "Guardar Salário", url: "guardarsalario" },
  //   { icon: "fa-money", name: "Investimentos", url: "investimentos" }
  // ]
}
