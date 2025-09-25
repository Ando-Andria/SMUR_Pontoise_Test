import axios from "axios";
import { environment } from "../environment/environment"; 

const api = axios.create({
  baseURL: environment.apiBaseUrl,
  headers: {
    "Content-Type": "application/json",
  },
});

export class ApiService {
  static async getList(endpoint, params) {
    const response = await api.get(endpoint, { params });
    return response.data;
  }

  static async getById(endpoint, id) {
    const response = await api.get(`${endpoint}/${id}`);
    return response.data;
  }

  static async create(endpoint, body, headers) {
    const response = await api.post(endpoint, body, { headers });
    return response.data;
  }

  static async update(endpoint, body) {
    const response = await api.put(endpoint, body);
    return response.data;
  }

  static async patch(endpoint, body) {
    const response = await api.patch(endpoint, body);
    return response.data;
  }

  static async delete(endpoint, id) {
    await api.delete(`${endpoint}/${id}`);
  }

  static async deletes(endpoint, params) {
    await api.delete(endpoint, { params });
  }

  static async getSingle(endpoint) {
    const response = await api.get(endpoint);
    return response.data;
  }

  static async updates(endpoint, body, params) {
    const response = await api.put(endpoint, body, { params });
    return response.data;
  }
}
