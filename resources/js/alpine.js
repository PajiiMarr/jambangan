document.addEventListener('alpine:init', () => {
    Alpine.data('search', () => ({
        searchOpen: false,
        searchQuery: '',
        searchResults: [],
        
        performSearch() {
            // This is a placeholder for actual search functionality
            // You would typically make an API call here
            this.searchResults = [
                {
                    id: 1,
                    type: 'Performance',
                    title: 'Sample Performance',
                    description: 'A beautiful cultural dance performance',
                    url: '#performances'
                },
                {
                    id: 2,
                    type: 'Event',
                    title: 'Upcoming Event',
                    description: 'Join us for an amazing cultural showcase',
                    url: '#upcoming-events'
                },
                {
                    id: 3,
                    type: 'Post',
                    title: 'Latest News',
                    description: 'Read about our latest achievements',
                    url: '#posts'
                }
            ];
        }
    }));
});