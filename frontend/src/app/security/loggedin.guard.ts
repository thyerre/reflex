import { CanLoad, Route, CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router'
import { Injectable } from '@angular/core';
import { LoginService } from './login/login.service';

@Injectable()

export class LoggedInGuard implements CanLoad, CanActivate {
    hasPermission: boolean = true;

    constructor(private loginService: LoginService) { }

    checkAuthentication(path: string): boolean {
        const loggedIn = this.loginService.isLoggedIn()
        // console.log(loggedIn)
        if (!loggedIn) {
            this.loginService.handleLogin()
        }
        return loggedIn
    }
    checkPermission(route): Promise<Boolean>{
            return new Promise((resolve, reject) => {
                // this.loginService.checkPermission(route).subscribe(permission => {
                    if (!true) {
                        if (route != 'not-found') {
                            this.loginService.notificationError("Sem Permissão " + route)
                            resolve(true)
                        }
                        if (route == 'pdv') {
                            setTimeout(() => { this.loginService.navGoTo('not-found'); }, 3000);//esperando 3 segundos e fechando a janela.
                            resolve(true)
                        } else {
                            if (route != 'not-found') {
                                this.loginService.navGoTo('not-found');
                                resolve(true)
                            }
                        }
                    }
                    resolve(true)
                })
            // })
    }
    
    canLoad(route: Route) {
        // return false;
        if (!this.checkAuthentication(route.path)) {
            return false;
        }

        return this.checkPermission(route.path).then(expiresAt => {
            if(expiresAt){
                return true
            }
            return false;
        })
        .catch((err) => {
            return false
            
        });

    }
    canActivate(activatedRoute: ActivatedRouteSnapshot, routerState: RouterStateSnapshot): boolean {
        let hasPermisson = this.checkPermission(activatedRoute.routeConfig.path);
        if(!hasPermisson){
            return false;
        }
        return this.checkAuthentication(activatedRoute.routeConfig.path)
    }
}