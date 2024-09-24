"use client"; // Add this directive at the top

import React, { useEffect, useState, useCallback } from "react";
import Header from "@/app/(app)/Header";
import NewsCard from "@/components/NewsCard";
import axios from "@/lib/axios";
import InfiniteScroll from "react-infinite-scroll-component";

const Dashboard = () => {
    const [news, setNews] = useState([]);
    const [page, setPage] = useState(1);
    const [hasMore, setHasMore] = useState(true);
    const [loading, setLoading] = useState(false);
    const [searchTerm, setSearchTerm] = useState("");
    const [category, setCategory] = useState("");
    const [categories, setCategories] = useState([]);

    const fetchCategories = useCallback(async () => {
        try {
            const response = await axios.get(`/api/categories`);
            setCategories(response.data.categories);
        } catch (error) {
            console.error("Error fetching categories:", error);
        }
    }, []);

    const fetchNews = useCallback(async () => {
        if (loading) return; // Prevent multiple fetches
        setLoading(true);
        console.log("Fetching news...", { page, searchTerm, category });
        try {
            const response = await axios.get(`/api/articles`, {
                params: {
                    page,
                    search: searchTerm,
                    category,
                },
            });
            const data = response.data;
            console.log("Fetched news data:", data);
            if (page === 1) {
                setNews(data.data);
            } else {
                setNews((prevNews) => [...prevNews, ...data.data]);
            }
            setHasMore(data.current_page < data.last_page);
        } catch (error) {
            console.error("Error fetching news:", error);
        } finally {
            setLoading(false);
        }
    }, [page, searchTerm, category]);

    useEffect(() => {
        fetchCategories();
    }, [fetchCategories]);

    useEffect(() => {
        fetchNews();
    }, [fetchNews, page]);

    const handleSearchChange = (e) => {
        setSearchTerm(e.target.value);
        setPage(1);
        setNews([]);
    };

    const handleCategoryChange = (e) => {
        setCategory(e.target.value);
        setPage(1);
        setNews([]);
    };

    return (
        <>
            <Header title="Dashboard" />
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                            <div className="flex space-x-4">
                                <input
                                    type="text"
                                    placeholder="Search..."
                                    value={searchTerm}
                                    onChange={handleSearchChange}
                                    className="border p-2 rounded"
                                />
                                <select
                                    value={category}
                                    onChange={handleCategoryChange}
                                    className="border p-2 rounded"
                                >
                                    <option value="">All Categories</option>
                                    {categories.map((cat) => (
                                        <option key={cat.id} value={cat.name}>
                                            {cat.name}
                                        </option>
                                    ))}
                                </select>
                            </div>
                        </div>
                    </div>
                    <InfiniteScroll
                        dataLength={news.length}
                        next={() => setPage((prevPage) => prevPage + 1)}
                        hasMore={hasMore}
                        loader={
                            <div className="text-center mt-4">
                                Loading more articles...
                            </div>
                        }
                        endMessage={
                            <div className="text-center mt-4">
                                No more articles
                            </div>
                        }
                    >
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
                            {news.map((article, index) => (
                                <NewsCard
                                    key={index}
                                    title={article.title}
                                    description={article.description}
                                    url={article.url}
                                    imageUrl={article.image_url}
                                    imagePayload={article.image_payload}
                                />
                            ))}
                        </div>
                    </InfiniteScroll>
                </div>
            </div>
        </>
    );
};

export default Dashboard;