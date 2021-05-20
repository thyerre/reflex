import { Component, OnInit } from '@angular/core';
import { NotificationService } from '../shared/messages/notification.service';
import { BreadcrumbService } from '../layout/breadcrumb/breadcrumb.service';

@Component({
  selector: 'mt-not-found',
  templateUrl: './not-found.component.html',
  styleUrls: ['./not-found.component.css']
})
export class NotFoundComponent implements OnInit {

  constructor(private notificationService:NotificationService,private breadcrumbService:BreadcrumbService) { }

  // lottieConfig = {
  //   path: 'https://assets5.lottiefiles.com/datafiles/sPJTLSWjrBGgvJK/data.json', 
  //   autoplay: true,
  //   loop: true
  // };
  lottieConfig = {
    // path: 'assets/animations/json/404.json', 
    // path: 'assets/animations/json/404-1.json', 
    // path: 'assets/animations/json/404-2.json', 
    path: 'assets/animations/json/404-3.json', 
    
    autoplay: true,
    loop: true
  };
  
  ngOnInit() {
    this.breadcrumbService.chosenPagina([
			{ no_rotina: "Página não encontrada", ds_url: "/",active:'active' }
		  ])
  }
  

}
