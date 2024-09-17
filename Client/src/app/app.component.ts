import { Component, inject } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { OnInit } from '@angular/core';
import {User} from './_models/user';
import { HttpClient } from '@angular/common/http';
import { environment } from '../environments/environment';
import { CommonModule, NgFor } from '@angular/common';
import { NavComponent } from './nav/nav.component';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet, NgFor,CommonModule, NavComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent implements OnInit {
  title = 'RepaircafeReservation';
  http=inject(HttpClient);

  constructor()
  {

  }


  ngOnInit(): void
  {
    this.http.get<User>(`${environment.apiUrl}/user/1`)
      .subscribe({
      next: (user) => {
        localStorage.setItem('user', JSON.stringify(user));
        this.setCurrentUser();
      },
      error: (err) => console.error('Failed to fetch user', err),
      complete: () => console.log('User fetched successfully')
      });
  }

  setCurrentUser()
  {
    const userStr = localStorage.getItem('user');
    if(!userStr) return;
    const user:User = JSON.parse(userStr);
    //this.accountService.setCurrentUser(user);
  }

}
