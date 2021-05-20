import { Component, OnInit } from "@angular/core";
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { ActivatedRoute, Router } from "@angular/router";
import { LoginService } from "./login.service";
import { User } from "./user.model";
import { NotificationService } from "../../shared/messages/notification.service";

@Component({
  selector: "app-login",
  templateUrl: "./login.component.html",
  styleUrls: ["./login.component.css"],
})
export class LoginComponent implements OnInit {
  loginForm: FormGroup;

  constructor(
    private fb: FormBuilder,
    private loginService: LoginService,
    private notificationService: NotificationService,
    private activatedRoute: ActivatedRoute,
    private router: Router
  ) {}

  ngOnInit() {
    this.isLoggedIn();
    this.loginForm = this.fb.group({
      login: this.fb.control("", [Validators.required]),
      password: this.fb.control("", [Validators.required]),
    });
  }
  isLoggedIn() {
    if (this.loginService.isLoggedIn()) {
      window.location.replace("dashboard");
    }
  }
  login() {
    this.loginService
      .login(this.loginForm.value.login, this.loginForm.value.password)
      .subscribe(
        (user) => {
          window.location.replace("data-warehouse");
          // window.location.reload();
        },

        (response) => {
          if (response.status === 401) {
            this.notificationService.notifyAlert("Usuário ou senha inválida");
          }
          if (response.status === 0) {
            this.notificationService.notifyError("SERVIDOR OFFILINE");
          }
        } //httpErrorResponse
        // () => {}
      );
  }
}
