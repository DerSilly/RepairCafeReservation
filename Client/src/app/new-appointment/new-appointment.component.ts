import { Component, inject } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { OnInit } from '@angular/core';
import { environment } from '../../../src/environments/environment';
import { DatePipe, NgFor } from '@angular/common';
import { Appointment } from '../_models/appointment';
import { Location as AppLocation } from '../_models/location';
import { User } from '../_models/user';
import { Device } from '../_models/device';
import { AccountService } from '../_services/account.service';
import { HttpClient } from '@angular/common/http';
import { TimepickerModule } from 'ngx-bootstrap/timepicker';

@Component({
  selector: 'app-new-appointment',
  standalone: true,
  imports: [FormsModule, NgFor, DatePipe, TimepickerModule ],
  templateUrl: './new-appointment.component.html',
  styleUrl: './new-appointment.component.css'
})

export class NewAppointmentComponent implements OnInit{
  now = new Date();
  accountService = inject(AccountService);
  httpClient = inject(HttpClient);
  nicknames: string[] = [];
  locations: AppLocation[] = [];
  step: number = 0;
  stepCnt: number = 3;
  appointment: Appointment = {} as Appointment;

  ngOnInit(): void {
    this.appointment.guest = {} as User;
    this.appointment.device = {} as Device;

    this.getNicknames();
    this.getLocations();
    this.appointment.location = this.locations.length > 0 ? this.locations[0] : {id: 1} as AppLocation;
    this.appointment.startTime = this.now;
    this.appointment.endTime = new Date(this.now.getTime() + 15 * 60000);
  }

  getNicknames(): void {
    fetch(`${environment.apiUrl}nicknames`)
    .then(response => response.json())
    .then(data => {
    this.nicknames = data;
    })
      .catch(error => {
      console.error('Error fetching nicknames:', error);
    });
  }

  getLocations(): void {
     this.httpClient.get<AppLocation[]>(`${environment.apiUrl}locations`).subscribe({
      next: (data: AppLocation[]) => {
        this.locations = data;
      }
    });
  }

  submit() {
    if (this.step === this.stepCnt) {
      this.httpClient.post<Appointment>(`${environment.apiUrl}appointments`, this.appointment).subscribe({
      next: (response) => {
        console.log('Appointment created successfully:', response);
      },
      error: (error) => {
        console.error('Error creating appointment:', error);
      }
          });
    }
    this.step++;
  }

  back() {
    this.step = this.step - 1;
  }
}
