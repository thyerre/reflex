import { NgModule, ModuleWithProviders, LOCALE_ID } from "@angular/core";
import { CommonModule, registerLocaleData } from "@angular/common";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";

import { InputComponent } from "./input/input.component";
import { RadioComponent } from "./radio/radio.component";

import { SnackbarComponent } from "./messages/snackbar/snackbar.component";

import { HTTP_INTERCEPTORS } from "@angular/common/http";
import { MatTreeModule } from "@angular/material/tree";
import { NotificationService } from "./messages/notification.service";
import { LoginService } from "../security/login/login.service";
import { LoggedInGuard } from "../security/loggedin.guard";
import { AuthInterceptor } from "../security/auth.interceptor";

import { FormWizardModule } from "angular2-wizard";
import { MenuService } from "../layout/menu/menu.service";
// import { CurrencyMaskModule } from "ng2-currency-mask";
// pipes
import { EncryptPipe } from "../pipes/encrypt.pipe";
import { Helper } from "../helper";
import { HelpersPipe } from "../pipes/helpers.pipe";
import { NgSelectModule } from "@ng-select/ng-select";
import { ToastrModule } from "ngx-toastr";
import { MatDatepickerModule } from "@angular/material/datepicker";
import { DragDropModule } from "@angular/cdk/drag-drop";
import {
  MatNativeDateModule,
  MAT_DATE_LOCALE,
  MatTooltipModule,
  MatCardModule,
} from "@angular/material";
import { MatIconModule } from "@angular/material/icon";
import { PerfectScrollbarModule } from "ngx-perfect-scrollbar";
import { PERFECT_SCROLLBAR_CONFIG } from "ngx-perfect-scrollbar";
import { PerfectScrollbarConfigInterface } from "ngx-perfect-scrollbar";
import ptBr from "@angular/common/locales/pt";

import { ChartsModule } from "ng2-charts";

import { LottieAnimationViewModule } from "ng-lottie";
import { TextMaskModule } from "angular2-text-mask";
import { MatBottomSheetModule } from "@angular/material/bottom-sheet";
import { MatButtonModule } from "@angular/material/button";
import { MatStepperModule } from "@angular/material/stepper";
registerLocaleData(ptBr);

const DEFAULT_PERFECT_SCROLLBAR_CONFIG: PerfectScrollbarConfigInterface = {
  suppressScrollX: true,
};

@NgModule({
  declarations: [
    InputComponent,
    RadioComponent,
    SnackbarComponent,
    EncryptPipe,
    HelpersPipe,
  ],

  imports: [
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
    FormWizardModule,
    MatDatepickerModule,
    NgSelectModule,
    MatNativeDateModule,
    MatTooltipModule,
    MatCardModule,
    DragDropModule,
    PerfectScrollbarModule,
    MatTreeModule,
    MatIconModule,
    MatBottomSheetModule,
    MatButtonModule,
    MatStepperModule,
    ChartsModule,
    ToastrModule.forRoot(),
    LottieAnimationViewModule.forRoot(),
    // CurrencyMaskModule,
    TextMaskModule,
  ],
  exports: [
    InputComponent,
    RadioComponent,
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
    SnackbarComponent,
    EncryptPipe,
    HelpersPipe,
    FormWizardModule,
    MatDatepickerModule,
    NgSelectModule,
    MatNativeDateModule,
    MatTooltipModule,
    MatCardModule,
    DragDropModule,
    PerfectScrollbarModule,
    MatTreeModule,
    MatIconModule,
    MatBottomSheetModule,
    MatButtonModule,
    ToastrModule,
    LottieAnimationViewModule,
    ChartsModule,
    MatStepperModule,
    // CurrencyMaskModule,
    TextMaskModule,
  ],
})
export class SharedModule {
  static forRoot(): ModuleWithProviders {
    return {
      ngModule: SharedModule,
      providers: [
        NotificationService,
        LoginService,
        LoggedInGuard,
        MenuService,
        Helper,
        { provide: LOCALE_ID, useValue: "pt-br" },
        { provide: MAT_DATE_LOCALE, useValue: "pt-br" },
        { provide: HTTP_INTERCEPTORS, useClass: AuthInterceptor, multi: true },
        // {provide:HTTP_INTERCEPTORS, useClass: AuthRefreshtokenInterceptor, multi:true},
        {
          provide: PERFECT_SCROLLBAR_CONFIG,
          useValue: DEFAULT_PERFECT_SCROLLBAR_CONFIG,
        },
      ],
    };
  }
}
