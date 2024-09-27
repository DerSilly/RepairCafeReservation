import { Component, inject } from '@angular/core';
import { Router } from '@angular/router';
import { AccountService } from '../_services/account.service';
import { User } from '../_models/user';
import { ToastrService } from 'ngx-toastr';
import { FormsModule } from '@angular/forms';
import { BsDropdownModule } from 'ngx-bootstrap/dropdown';

@Component({
  selector: 'app-nav',
  standalone: true,
  imports: [FormsModule,BsDropdownModule],
  templateUrl: './nav.component.html',
  styleUrl: './nav.component.css'
})
export class NavComponent {
  toastr = inject(ToastrService);
  accountService = inject(AccountService);
  router = inject(Router);
  user: User|undefined ;

  login()
  {
    this.accountService.login(this.user).subscribe({
      next: _ => {this.router.navigateByUrl('/newAppointment');},
      error: (error) => {this.toastr.error(error.error);}
    });
  }

  logout ()
  {
    this.accountService.logout();
    this.router.navigate(['/']);
  }
}
