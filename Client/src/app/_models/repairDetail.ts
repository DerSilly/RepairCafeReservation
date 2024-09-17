export interface RepairDetail {
  repairerId: number | null;
  deviceId: number;
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
}
