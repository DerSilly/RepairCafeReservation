import { Device } from "./device";
import { User } from "./user";

export interface RepairDetail {
  repairer: User
  repairDate: Date;
  fault: string;
  solution: string;
  repairability: number;
  repairFailedReason: string | null;
  advice: string | null;
  repairSource: string | null;
  hint: string | null;
  createdAt: Date;
  updatedAt: Date;
  device: Device
}
