import { NgModule } from '@angular/core'
import { SharedModule } from '../../shared/shared.module'
import { RouterModule, Routes } from '@angular/router'
import { HomeComponent } from './home.component';

const ROUTES: Routes = [
  { path: '', component: HomeComponent }
];
@NgModule({
  declarations: [
    HomeComponent
  ],
  imports: [
    SharedModule,
    RouterModule.forChild(ROUTES)
  ]
})
export class HomeModule { }
