import { Component, OnInit } from "@angular/core";
import {
  FormBuilder,
  FormControl,
  FormGroup,
  Validators,
} from "@angular/forms";
import { ConfiguracaoService } from "./configuracao.service";
import { Helper } from "../helper";
import { BreadcrumbService } from "../layout/breadcrumb/breadcrumb.service";
import swal from "sweetalert2";

@Component({
  selector: "app-configuracao",
  templateUrl: "./configuracao.component.html",
  styleUrls: ["./configuracao.component.css"],
})
export class ConfiguracaoComponent implements OnInit {
  dataWarehouses: any[];
  form: FormGroup;
  searchControl: FormControl;
  loaderDone: boolean = false;
  page: number = 1;
  itensPorPagina = 10;
  order: any = {};
  columns: any;
  Periodos: any[] = [
    { id: "DIA", value: "Diário" },
    { id: "MEN", value: "Mensal" },
    { id: "SEM", value: "Semanal" },
  ];
  status: any[] = [
    { id: 1, value: "Ativo" },
    { id: 0, value: "Inatívo" },
  ];
  dataBR = [/[0-9]/, /\d/, "/", /\d/, /\d/, "/", /\d/, /\d/, /\d/, /\d/];
  horaBR = [/[0-9]/, /\d/, ":", /\d/, /\d/];
  informacoes: any[] = [];
  interomperLoop: boolean = false;

  constructor(
    private configuracaoService: ConfiguracaoService,
    private fb: FormBuilder,
    private helper: Helper,
    private breadcrumbService: BreadcrumbService
  ) {}

  ngOnInit() {
    this.breadcrumbService.chosenPagina([
      { no_rotina: "Configuração", ds_url: "configuracao", active: "" },
      { no_rotina: "Listar", ds_url: "configuracao", active: "active" },
    ]);
    this.getDatawareHouses();
    this.initForm();
  }

  initForm() {
    this.form = this.fb.group({
      id_data_warehouse: this.fb.control("", [Validators.required]),
      periodo: this.fb.control("", [Validators.required]),
      bo_diario: this.fb.control(""),
      bo_semanal: this.fb.control(""),
      bo_mensal: this.fb.control(""),
      dt_inicial: this.fb.control("", [Validators.required]),
      qt_registros: this.fb.control("", [Validators.required]),
      hora: this.fb.control("", [Validators.required]),
      bo_ativo: this.fb.control(true, [Validators.required]),
    });
  }

  getColumnsShow(ar) {
    let columns = {};
    columns["id"] = { name: "id", show: true };
    columns["no_grupo_permissao"] = { name: "no_grupo_permissao", show: true };
    columns["bo_ativo"] = { name: "bo_ativo", show: true };
    columns["id_empresa"] = { name: "id_empresa", show: true };
    columns["created_at"] = { name: "created_at", show: true };
    columns["updated_at"] = { name: "updated_at", show: true };

    this.columns = columns;
  }

  getDatawareHouses() {
    this.configuracaoService.getDatawareHouse().subscribe((configuracao) => {
      this.dataWarehouses = configuracao;
      this.loaderDone = true;
    });
  }

  getConfiguracaoByIdDataWarehouse(id) {
    this.configuracaoService
      .getConfiguracaoByIdDataWarehouse(id)
      .subscribe((configuracao) => {
        this.form
          .get("id_data_warehouse")
          .setValue(configuracao.id_data_warehouse);
        this.form.get("bo_ativo").setValue(configuracao.bo_ativo);
        this.form.get("dt_inicial").setValue(configuracao.dt_inicial);
        this.form.get("hora").setValue(configuracao.hora);
        this.form.get("qt_registros").setValue(configuracao.qt_registros);
        this.formatarChegada(configuracao);
      });
  }

  update(form) {
    this.configuracaoService.update(
      this.formatarEnvio(form),
      form.id_data_warehouse
    );
  }

  orderby(column) {
    this.dataWarehouses = this.helper.orderby(
      column,
      this.dataWarehouses,
      this.order
    );
  }

  hideshowColumns(column) {
    this.columns[column].show = this.columns[column].show ? false : true;
  }

  formatarEnvio(form) {
    if (form.periodo == "DIA") {
      form.bo_diario = true;
    } else if (form.periodo == "SEM") {
      form.bo_semanal = true;
    } else {
      form.bo_mensal = true;
    }
    delete form.periodo;
    return form;
  }

  formatarChegada(configuracao) {
    if (configuracao.bo_diario) {
      this.form.get("periodo").setValue("DIA");
    } else if (configuracao.bo_semanal) {
      this.form.get("periodo").setValue("SEM");
    } else {
      this.form.get("periodo").setValue("MES");
    }
  }

  getInfo(id) {
    this.informacoes = [];
    this.getInformacoesAtualizacao(id);
  }

  getInformacoesAtualizacao(id) {
    this.configuracaoService.getInformacoesAtualizacao(id).subscribe((info) => {
      this.informacoes = info.dados;
    });
  }
}
