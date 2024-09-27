import { User } from './user';
import { Device } from './device';

export interface  Appointment {
  id: number;
  staffId: number | null;
  startTime: Date;
  endTime: Date;
  note: string | null;
  isDeleted: boolean;
  guest: User;
  device: Device
  location: Location
}
