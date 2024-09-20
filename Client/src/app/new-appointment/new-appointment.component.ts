import { Component, inject } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { OnInit } from '@angular/core';
import { environment } from '../../../src/environments/environment';
import { NgFor } from '@angular/common';

@Component({
  selector: 'app-new-appointment',
  standalone: true,
  imports: [FormsModule, NgFor],
  templateUrl: './new-appointment.component.html',
  styleUrl: './new-appointment.component.css'
})

export class NewAppointmentComponent implements OnInit{
  nicknames: string[] = [];

  ngOnInit(): void {
      this.getNicknames();
  }

  getNicknames(): void {
  fetch(`${environment.apiUrl}/nicknames`)
    .then(response => response.json())
    .then(data => {
    this.nicknames = data;
    })
    .catch(error => {
    console.error('Error fetching nicknames:', error);
    });
}

  submit() {
    // Handle form submission logic here
  }

}
