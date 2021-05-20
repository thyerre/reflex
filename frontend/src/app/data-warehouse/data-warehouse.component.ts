import { Component, OnInit, ElementRef, ViewChild } from "@angular/core";
import { DataWarehouseService } from "./data-warehouse.service";
import Swal from "sweetalert2";
import { elementAt } from "rxjs/operators";
import { BreadcrumbService } from "../layout/breadcrumb/breadcrumb.service";
import { FormBuilder, FormGroup, Validators } from "@angular/forms";

@Component({
  selector: "data-warehouse",
  templateUrl: "./data-warehouse.component.html",
  styleUrls: ["./data-warehouse.component.css"],
})
export class DataWarehouseComponent implements OnInit {
  tables: any[] = [];
  allTables: any[] = [];
  allColumns: any[] = [];
  columns: any[] = [];
  allColumnsDelete: any[] = [];
  fksAtiva: boolean = false;
  form: FormGroup;

  @ViewChild("closeBtnTable", { static: true }) closeBtnTable: ElementRef;
  @ViewChild("closeBtnColumns", { static: true }) closeBtnColumns: ElementRef;
  @ViewChild("openModalColumns", { static: true }) openModalColumns: ElementRef;
  constructor(
    private dataWarehouseService: DataWarehouseService,
    private breadcrumbService: BreadcrumbService,
    private fb: FormBuilder
  ) {}

  ngOnInit() {
    this.breadcrumbService.chosenPagina([
      { no_rotina: "Data Warehouse", ds_url: "data-warehouse", active: "" },
      { no_rotina: "Criar", ds_url: "data-warehouse", active: "active" },
    ]);
    this.getTables();
    this.initForm();
  }

  initForm() {
    this.form = this.fb.group({
      no_data_warehouse: this.fb.control("", [Validators.required]),
      ds_data_warehouse: this.fb.control("", [Validators.required]),
    });
  }

  gerarDataWareHouse() {
    let ar: any = {};
    ar.columns = this.allColumns;
    ar.tables = this.getTabelasByColunas(this.tables, this.allColumns);
    ar.no_data_warehouse = this.form.value.no_data_warehouse;
    ar.ds_data_warehouse = this.form.value.ds_data_warehouse;
    this.dataWarehouseService.gerarDataWarehouse(ar).subscribe((res) => {
      Swal.fire({
        position: 'center',
        type: 'success',
        title: `Estrutura criada com sucesso!`,
        showConfirmButton: false,
        timer: 1500
      })
      this.clear();
    });
  }

  getTabelasByColunas(tabelas, colunas) {
    let arTabelas = [];
    colunas.forEach((coluna) => {
      let tab = tabelas.filter((tabela) => {
        return tabela.name == coluna.table;
      })[0];
      arTabelas.push(tab);
    });
    return arTabelas;
  }

  getTables() {
    if (!this.tables || this.tables.length == 0) {
      this.dataWarehouseService.getAllTables().subscribe((tables) => {
        this.tables = tables;
        this.allTables = tables;
      });
    }
  }
  setSelectsFalseTabela() {
    for (var index of this.tables.keys()) {
      this.tables[index].select = false;
    }
  }

  setSelectsFalseColunas() {
    for (var index of this.columns.keys()) {
      this.columns[index].select = false;
    }
  }

  selecionarTabela(tabela) {
    this.setSelectsFalseTabela();
    tabela.select = true;
    this.getColumnsByTable(tabela.name);
  }

  selectColumn(column) {
    this.setSelectsFalseColunas();
    column.select = true;
    if (this.verificarColunaExiste(column)) {
      return;
    }
    this.allColumns.push(column);
    this.selectTablesFK(column.table);
  }

  selectTablesFK(table) {
    this.getFKByTable(table);
  }

  verificarColunaExiste(column) {
    var col = this.allColumns.filter((elem) => {
      return elem.field == column.field;
    });
    return col.length > 0 ? true : false;
  }

  setColumnsSelected(table) {
    let colSelect = this.allColumns.filter(function (col) {
      return col.table == table;
    });
    if (colSelect.length > 0) {
    }
  }

  removeColumn(column) {
    this.allColumnsDelete.push(column);
    this.allColumns.splice(this.allColumns.indexOf(column), 1);
  }

  removeColumnsSelected(table) {
    this.allColumns = this.allColumns.filter(function (col) {
      return col.table != table;
    });
  }

  getColumnsByTable(table) {
    this.dataWarehouseService.getColumnsByTable(table).subscribe((columns) => {
      this.columns = columns;
    });
  }

  selectColumns() {
    const cols = this.columns.filter(function (col) {
      return col.select;
    });
    this.allColumns = this.allColumns.concat(cols);
    this.closeBtnColumns.nativeElement.click();
  }
  getTabelasComFK() {}

  getFKByTable(table) {
    this.dataWarehouseService.getFKByTable(table).subscribe((tablesFKs) => {
      let tab = [];
      if (!this.fksAtiva) {
        tablesFKs.unshift({ tables: table });
        this.tables = [];
        for (let tabela of tablesFKs) {
          tab = this.allTables.filter((elem) => {
            return elem.name == tabela.tables;
          });
          tab[0].fk = table;
          if (tab[0].name == table) {
            tab[0].primary = true;
          }
          this.tables.push(tab[0]);
        }
      } else {
        for (let tabela of tablesFKs) {
          tab = this.allTables.filter((elem) => {
            return elem.name == tabela.tables;
          });
          if (Array.isArray(tab) && tab.length > 0) {
            let existTabelaInArray = this.tables.filter((elem) => {
              return elem.name == tab[0].name && elem.fk == table;
            });
            if (existTabelaInArray.length == 0) {
              tab[0].fk = table;
              this.tables.push(tab[0]);
            }
          }
        }
      }
      if (!this.fksAtiva) {
        this.fksAtiva = true;
      }
    });
  }
  alterPosition(column, tipo) {
    var index = this.allColumns.indexOf(column);
    var indexPrevius = undefined;
    if (tipo == "+") {
      indexPrevius = index + 1;
    } else {
      indexPrevius = index - 1;
    }
    var column1 = this.allColumns[index];
    var column2 = this.allColumns[indexPrevius];
    this.allColumns[index] = column2;
    this.allColumns[indexPrevius] = column1;
  }
  removerColumnsRemoved(columns, allColumns) {
    var cols = columns.filter(function (elemx) {
      var result = allColumns.filter(function (elemy) {
        return elemx.field == elemy.field;
      });
      if (result) {
        return false;
      } else {
        return true;
      }
    });
    return cols;
  }

  clear() {
    this.tables = [];
    this.allColumns = [];
    this.allColumnsDelete = [];
    this.getTables();
  }
}
