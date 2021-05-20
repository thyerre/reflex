import { Component, OnInit, ElementRef, ViewChild } from "@angular/core";
import { LoginService } from "../../security/login/login.service";
import { API_PATH_IMG } from "src/app/app.api";
import { FormGroup, FormBuilder, Validators } from "@angular/forms";
import { HeaderService } from "./header.service";
import { NavigationEnd, Router } from "@angular/router";

@Component({
  selector: "app-header",
  templateUrl: "./header.component.html",
  styleUrls: ["./header.component.css"],
})
export class HeaderComponent implements OnInit {
  temBoleto: boolean = false;
  logo: any = "";
  boletoMensalidade: any = {};
  drivers = [
    { driver: "mysql", name: "mysql" },
    // { driver: "pgsql", name: "pgsql" },
  ];
  formHost: FormGroup;
  formServe: FormGroup;
  @ViewChild("openNotifications", { static: true })
  openNotifications: ElementRef;
  exibirConf: boolean = false;

  constructor(
    private loginService: LoginService,
    private headerService: HeaderService,
    private fb: FormBuilder,
    private router: Router
  ) {}

  ngOnInit() {
    this.logo = `${API_PATH_IMG}/sagesc/logo.png`;
    this.initFormHost();
    this.initFormServe();
    this.verificarConfig();
  }

  logout() {
    this.loginService.logout();
  }
  initFormHost() {
    this.formHost = this.fb.group({
      id: this.fb.control("", [Validators.required]),
      no_database: this.fb.control("", [Validators.required]),
      driver: this.fb.control("", [Validators.required]),
      usuario: this.fb.control("", [Validators.required]),
      password: this.fb.control("", [Validators.required]),
      host: this.fb.control("", [Validators.required]),
      port: this.fb.control("", [Validators.required]),
      type: this.fb.control("", [Validators.required]),
      charset: this.fb.control("", [Validators.required]),
    });
  }

  initFormServe() {
    this.formServe = this.fb.group({
      id: this.fb.control("", [Validators.required]),
      no_database: this.fb.control("", [Validators.required]),
      driver: this.fb.control("", [Validators.required]),
      usuario: this.fb.control("", [Validators.required]),
      password: this.fb.control("", [Validators.required]),
      host: this.fb.control("", [Validators.required]),
      port: this.fb.control("", [Validators.required]),
      type: this.fb.control("", [Validators.required]),
      charset: this.fb.control("", [Validators.required]),
    });
  }

  verificarConfig() {
    this.router.events.subscribe((event) => {
      if (event instanceof NavigationEnd) {
        this.exibirConf = false;
        if (event.url == "/data-warehouse") {
          this.exibirConf = true;
        }
      }
    });
  }

  updateConfig(form) {
    this.headerService.saveConfigDatabase(form).subscribe((config) => {
      if (config) {
        this.headerService.notify("salvo com sucesso!");
        window.location.reload();
      }
    });
  }

  getConfigHost() {
    this.headerService.getConfigDatabase("host").subscribe((config) => {
      this.formHost.patchValue(config);
    });
  }

  getConfigServe() {
    this.headerService.getConfigDatabase("serve").subscribe((config) => {
      this.formServe.patchValue(config);
    });
  }
}
