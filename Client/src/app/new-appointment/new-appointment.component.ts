import { Component, inject } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { OnInit } from '@angular/core';
import { environment } from '../../../src/environments/environment';
import { DatePipe, NgFor, CommonModule } from '@angular/common';
import { Appointment } from '../_models/appointment';
import { Location as AppLocation } from '../_models/location';
import { User } from '../_models/user';
import { Device } from '../_models/device';
import { AccountService } from '../_services/account.service';
import { RepairsService } from '../_services/repairs.service';
import { HttpClient } from '@angular/common/http';
import { TimepickerModule } from 'ngx-bootstrap/timepicker';
import { BrowserModule} from '@angular/platform-browser';
import { Repair } from '../_models/repair';

@Component({
  selector: 'app-new-appointment',
  standalone: true,
  imports: [FormsModule, NgFor, DatePipe, TimepickerModule, CommonModule],
  templateUrl: './new-appointment.component.html',
  styleUrl: './new-appointment.component.css'
})

export class NewAppointmentComponent implements OnInit{

  changedProductKind()
  {
    this.categories = [...new Set(this.repairs.filter(r => r.kind_of_product == this.appointment.device.kindProduct).map(r => r.category))];
    this.faults = [...new Set(this.repairs.filter(r => r.kind_of_product == this.appointment.device.kindProduct).map(r => r.defect_found))];
    this.brands = [...new Set(this.repairs.filter(r => r.kind_of_product == this.appointment.device.kindProduct).map(r => r.brand))];
    this.models = [...new Set(this.repairs.filter(r => r.kind_of_product == this.appointment.device.kindProduct).map(r => r.model_type_number))];

  }

  changedBrand()
  {
    this.faults = [...new Set(this.repairs.filter(r => r.kind_of_product == this.appointment.device.kindProduct && r.brand == this.appointment.device.brand).map(r => r.defect_found))];
    this.models = [...new Set(this.repairs.filter(r => r.kind_of_product == this.appointment.device.kindProduct && r.brand == this.appointment.device.brand).map(r => r.model_type_number))];
  }

  changedModel()
  {
    this.faults = [...new Set(this.repairs.filter(r => r.kind_of_product == this.appointment.device.kindProduct && r.brand == this.appointment.device.brand && r.model_type_number == this.appointment.device.model).map(r => r.defect_found))];

    if (!this.appointment.device.productBuildYear) {
      const buildYears = this.repairs.filter(r => r.kind_of_product == this.appointment.device.kindProduct).map(r => r.year_of_production).sort((a, b) => a - b);
      const medianIndex = Math.floor(buildYears.length / 2);
      this.appointment.device.productBuildYear = buildYears[medianIndex];
    }
  }

  now = new Date();
  currentYear = new Date().getFullYear();
  accountService = inject(AccountService);
  repairsService = inject(RepairsService);
  httpClient = inject(HttpClient);
  nicknames: string[] = [];
  locations: AppLocation[] = [];
  step: number = 0;
  stepCnt: number = 3;
  appointment: Appointment = {} as Appointment;
  repairs: Repair[] = [];
  devices: string[] = [];
  categories: string[] = [];
  faults: string[] = [];
  brands: string[] = [];
  models: string[] = [];

  ngOnInit(): void {
    this.appointment.guest = {} as User;
    this.appointment.device = {} as Device;
    this.getNicknames();
    this.getLocations();

    this.appointment.location = this.locations.length > 0 ? this.locations[0] : {id: 1} as AppLocation;
    this.appointment.startTime = this.now;
    this.appointment.endTime = new Date(this.now.getTime() + 15 * 60000);
    this.repairsService.repairs$.subscribe({next: repairs => {
      this.repairs = repairs as Repair[];
      this.categories = [...new Set(this.repairs.map(r => r.category))];
      this.devices = [...new Set(this.repairs.map(r => r.kind_of_product))];
      this.faults = [...new Set(this.repairs.map(r => r.defect_found))];
      this.brands = [...new Set(this.repairs.map(r => r.brand))];
      this.models = [...new Set(this.repairs.map(r => r.model_type_number))];
      console.log('Repairs fetched:', JSON.stringify(this.repairs));},
      error: err => {console.error('Error fetching repairs:', err);}}
    );
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
