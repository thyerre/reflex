import { Routes } from "@angular/router";

import { LoginComponent } from "./security/login/login.component";

import { LoggedInGuard } from "./security/loggedin.guard";

export const ROUTES: Routes = [
  { path: "login/:to", component: LoginComponent },
  { path: "login", component: LoginComponent },
  { path: "", redirectTo: "data-warehouse", pathMatch: "full" },
  // {
  //   path: "dashboard",
  //   loadChildren: "./layout/home/home.module#HomeModule",
  //   canLoad: [LoggedInGuard],
  //   canActivate: [LoggedInGuard],
  // },
  {
    path: "data-warehouse",
    loadChildren: "./data-warehouse/data-warehouse.module#DataWarehouseModule",
    canLoad: [LoggedInGuard],
    canActivate: [LoggedInGuard],
  },
  {
    path: "configuracao",
    loadChildren: "./configuracao/configuracao.module#ConfiguracaoModule",
    canLoad: [LoggedInGuard],
    canActivate: [LoggedInGuard],
  },
  {
    path: "not-found",
    loadChildren: "./not-found/not-found.module#NotFoundModule",
    canActivate: [LoggedInGuard],
    canLoad: [LoggedInGuard],
  },
  { path: "**", redirectTo: "not-found", pathMatch: "full" },
];
