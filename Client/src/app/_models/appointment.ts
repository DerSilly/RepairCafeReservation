export interface  Appointment {
  id: number;
  guestId: number;
  staffId: number | null;
  startTime: Date;
  endTime: Date;
  locationId: number;
  note: string | null;
}
