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
            console.error('Error during GET request:', error.message);
            throw error;
        }
    }

    // POST request method
    async post(endpoint, body = {}) {
        try {
            const response = await fetch(new URL(endpoint, this.baseUrl), {
                method: 'POST',
                body: body,
            });

            return await this.handleResponse(response);
        } catch (error) {
            throw {description: error};
        }
    }

    // Response handler for success or failure
    async handleResponse(response) {
        if (!response.ok) {
            let errorMessage = `HTTP error! Status: ${response.status}`;
            try {
                const errorData = await response.json();
                errorMessage = errorData.error || errorMessage;
            } catch (parseError) {
                // Keep default error message if parsing fails
            }
            throw new Error(errorMessage);
        }
        return response.json();
    }
}