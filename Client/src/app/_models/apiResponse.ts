import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';



@NgModule({
  declarations: [],
  imports: [
    CommonModule
  ]
})
export class apiResponse
{
  success: boolean = false;
  message: string = '';
  data: any = {};
}
