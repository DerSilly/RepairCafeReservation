import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { HfInference } from '@huggingface/inference';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class LlamaService {
  private hf: HfInference;

  constructor(private http: HttpClient) {
    this.hf = new HfInference(environment.huggingFaceApiKey);
  }

  generateResponse(prompt: string): Observable<string> {
    return new Observable(observer => {
      this.hf.textGeneration({
        model: environment.AImodel,
        inputs: prompt,
        parameters: {
          max_new_tokens: 250,
          temperature: 0.7,
          top_p: 0.95,
          repetition_penalty: 1.15
        }
      }).then(response => {
        observer.next(response.generated_text);
        observer.complete();
      }).catch(error => {
        observer.error(error);
      });
    });
  }
}
