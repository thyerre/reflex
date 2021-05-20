import { NgModule } from "@angular/core";
import { SharedModule } from "../shared/shared.module";
import { RouterModule, Routes } from "@angular/router";
import { DataWarehouseComponent } from "./data-warehouse.component";

const ROUTES: Routes = [{ path: "", component: DataWarehouseComponent }];
@NgModule({
  declarations: [DataWarehouseComponent],
  imports: [SharedModule, RouterModule.forChild(ROUTES)],
})
export class DataWarehouseModule {}
