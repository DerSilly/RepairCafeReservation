export interface Device {
  id: number;
  kindProduct: string;
  category: string | null;
  brand: string | null;
  productBuildYear: number | null;
  model: string | null;
  fault: string;
  createdAt: Date | undefined;
  updatedAt: Date | undefined;
}
