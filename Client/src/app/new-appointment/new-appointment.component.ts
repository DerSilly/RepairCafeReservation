import { Component, inject } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { OnInit } from '@angular/core';
import { environment } from '../../../src/environments/environment';
import { LlamaService } from '../_services/ai.service';
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

  ai = inject(LlamaService);
  ngOnInit(): void {
      this.getNicknames();
  }

    getNicknames(): void {
      this.ai.generateResponse(environment.nicknamePrompt).subscribe(
        response => {
          this.nicknames = response.split('\n');
        },
        error => {
          console.error('Fehler bei der LLaMA-Anfrage:', error);
        });
  }

  submit() {
    // Handle form submission logic here
  }

}
