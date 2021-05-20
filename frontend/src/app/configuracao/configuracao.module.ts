import { NgModule } from "@angular/core";
import { SharedModule } from "../shared/shared.module";
import { RouterModule, Routes } from "@angular/router";
import { ConfiguracaoComponent } from "./configuracao.component";

const ROUTES: Routes = [{ path: "", component: ConfiguracaoComponent }];
@NgModule({
  declarations: [ConfiguracaoComponent],
  imports: [SharedModule, RouterModule.forChild(ROUTES)],
})
export class ConfiguracaoModule {}
