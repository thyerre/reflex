import {
  HttpInterceptor,
  HttpRequest,
  HttpHandler,
  HttpEvent,
} from "@angular/common/http";
import { Observable } from "rxjs";
import { Injectable, Injector } from "@angular/core";
import { LoginService } from "../security/login/login.service";

@Injectable()
export class AuthInterceptor implements HttpInterceptor {
  constructor(private injector: Injector) {}

  intercept(
    request: HttpRequest<any>,
    next: HttpHandler
  ): Observable<HttpEvent<any>> {
    const loginService = this.injector.get(LoginService);
    if (loginService.isLoggedIn()) {
      const authRequest = request.clone({
        setHeaders: {
          Authorization: `Bearer ${localStorage.getItem("dG9rZW5fc2FnZXNj")}`,
        },
      });
      return next.handle(authRequest);
    } else {
      return next.handle(request);
    }
  }
}
