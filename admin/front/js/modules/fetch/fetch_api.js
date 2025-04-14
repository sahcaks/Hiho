const MAIN_URL = location.protocol + "//" + location.host + "/hiho/";
export default class FetchAPI {
    constructor(baseUrl = MAIN_URL) {
        this.baseUrl = baseUrl;
    }

    // GET request method
    async get(endpoint, params = {}) {
        try {
            const url = new URL(endpoint, this.baseUrl);
            Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));  // Append query parameters to URL

            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                },
            });

            return this.handleResponse(response);
        } catch (error) {
            console.error('Error during GET request:', error);
            throw error;
        }
    }

    // POST request method
    async post(endpoint, body = {}) {
        try {
            const response = await fetch(new URL(endpoint, this.baseUrl), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(body),
            });

            return this.handleResponse(response);
        } catch (error) {
            console.error('Error during POST request:', error);
            throw error;
        }
    }

    // Response handler for success or failure
    async handleResponse(response) {
        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Something went wrong!');
        }
        return response.json();
    }
}