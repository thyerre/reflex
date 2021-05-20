import { Component, OnInit, AfterContentInit, OnDestroy } from "@angular/core";
import { ActivatedRoute } from "@angular/router";
import { BreadcrumbService } from "./../breadcrumb/breadcrumb.service";
import { API_PATH_IMG } from "src/app/app.api";

@Component({
  selector: "app-home",
  templateUrl: "./home.component.html",
  styleUrls: ["./home.component.css"],
})
export class HomeComponent implements OnInit, AfterContentInit, OnDestroy {
  id = 0;
  rotaAnexosFuncionario: string = API_PATH_IMG + "/funcionario/";
  rotaAnexosCliente: string = API_PATH_IMG + "/clienteFornecedor/";
  load: boolean = false;
  parcelaCliente: any[] = [];
  parcelaFornecedor: any[] = [];
  despesasVence: any[] = [];
  aniversariantes: any[] = [];
  data: any = new Date();
  infoParcelasReceber: any = {};
  infoContatoSagesc: any = [];
  infoParcelasPagar: any = {};
  produtosMaisVendidosMes: any = [];
  totalVendasPorDia: any = [];
  totalParcelasReceber: number = 0;
  totalParcelasFornecedor: number = 0;
  totalDespesasVence: number = 0;

  constructor(
    private router: ActivatedRoute,
    private breadcrumbService: BreadcrumbService
  ) {}
  ngOnInit() {
    this.router.params.subscribe((params) => {
      this.id = +params["id"];
    });
    this.breadcrumbService.chosenPagina([
      { no_rotina: "Home", ds_url: "/", active: "active" },
    ]);
  }

  compare(a, b) {
    return a.data > b.data;
  }
  liberarView() {
    this.load = false;
  }

  ngAfterContentInit(): void {
    document
      .getElementById("controlpanelbody")
      .setAttribute("style", "background-color:transparent !important");
  }
  ngOnDestroy(): void {
    document
      .getElementById("controlpanelbody")
      .setAttribute("style", "background-color:none !important");
  }
}
