import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { map, Observable } from 'rxjs';
import { environment } from '../../environments/environment';
import { Repair } from '../_models/repair';
import { OnInit } from '@angular/core';
import { apiResponse } from '../_models/apiResponse';
@Injectable({
  providedIn: 'root'
})
export class RepairsService {
  baseUrl = environment.apiUrl;
  repairs$: Observable<Repair[]>;

  constructor(private http: HttpClient) {
    const response = this.http.get<apiResponse>(this.baseUrl + 'repairs');

this.repairs$ = response.pipe(map(res => res.data as Repair[]));
}
}
