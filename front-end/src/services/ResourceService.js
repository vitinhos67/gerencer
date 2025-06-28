import axios from 'axios';

class ResourceService {
    constructor(resource) {
        this.resource = resource;
        this.http = axios.create({
            baseURL: process.env.VUE_APP_API_URL,
            headers: {
                'Content-Type': 'application/json'
            }
        });
    }

    async get(id) {
        const response = await this.http.get(`/${this.resource}/${id}`);
        return response.data;
    }

    async create(data) {
        const response = await this.http.post(`/${this.resource}`, data);
        return response.data;
    }
}

export default ResourceService;
