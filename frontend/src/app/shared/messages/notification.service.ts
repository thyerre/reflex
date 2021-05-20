import { EventEmitter } from "@angular/core";
import swal from 'sweetalert2';
import { ToastrService } from 'ngx-toastr';

export class NotificationService{
    constructor( private toastrService: ToastrService ) { }

    notifier = new EventEmitter<string>()

    notify(message:string,old=false){
        if(old){
            // this.notifier.emit(message)
            this.notifySweet(message)
        }else{
            this.showSuccess(message);//sudo npm install ngx-toastr --save
        }
    }
    showSuccess(message) {
        this.toastrService.success(message, '');
      }
    notifyToastrWarning(message) {
        this.toastrService.warning(message, '');
      }
    notifySweet(message:string){
        swal.fire({
            position: 'top',
            type: 'success',
            title: `${message}`,
            showConfirmButton: false,
            timer: 1500
          })
    }
    notifyError(message:string){
        swal.fire({
            position: 'top',
            type: 'error',
            title: `${message}`,
            showConfirmButton: false,
            timer: 4500
          })
    }
    notifyAlert(message:string){
        swal.fire({
            position: 'top',
            type: 'warning',
            title: `${message}`,
            showConfirmButton: false,
            timer: 1500
          })
    }
}