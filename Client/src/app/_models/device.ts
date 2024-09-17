export interface Device {
  id: number;
  kindProduct: string;
  category: string | null;
  brand: string | null;
  productBuildYear: number | null;
  model: string | null;
  causeOfFault: string;
  createdAt: Date;
  updatedAt: Date;
}
