import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-new-appointment',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './new-appointment.component.html',
  styleUrl: './new-appointment.component.css'
})
export class NewAppointmentComponent {

  submit() {
    // Handle form submission logic here
  }

}
