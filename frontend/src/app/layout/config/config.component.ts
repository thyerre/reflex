import { Component, OnInit, Renderer2 } from "@angular/core";

@Component({
  selector: "app-config",
  templateUrl: "./config.component.html",
  styleUrls: ["./config.component.css"],
})
export class ConfigComponent implements OnInit {
  theme: string = "theme-whbl";
  darkmode: boolean;
  pathcss: string = "../assets/css/theme-dark-full.min.css";

  constructor(private renderer: Renderer2) {
    this.renderer.addClass(document.body, this.theme);
  }

  ngOnInit(): void {
    this.darkmode = localStorage.getItem("darkmode") == "true" ? true : false;
    this.setTheme();
  }
  setDarkMode() {
    localStorage.setItem("darkmode", JSON.parse(this.darkmode.toString()));
    this.setTheme();
  }
  setTheme() {
    this.loadCSS();
  }
  loadCSS() {
    // Get HTML head element
    if (this.darkmode) {
      var head = document.getElementsByTagName("HEAD")[0];

      // Create new link Element
      var link = document.createElement("link");
      // set the attributes for link element
      link.rel = "stylesheet";
      link.type = "text/css";
      link.id = "iddarkmode";
      link.href = this.pathcss;
      // Append link element to HTML head
      head.appendChild(link);
    } else {
      var sheet = document.getElementById("iddarkmode");
      if (sheet != null) sheet.parentNode.removeChild(sheet);
    }
  }
}
