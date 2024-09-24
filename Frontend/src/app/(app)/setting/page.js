"use client";

import React, { useEffect, useState, useCallback } from "react";
import Header from "@/app/(app)/Header";
import axios from "@/lib/axios";

const Setting = () => {
    const [activeTab, setActiveTab] = useState("sources");
    const [sources, setSources] = useState([]);
    const [selectedSources, setSelectedSources] = useState([]);
    const [categories, setCategories] = useState([]);
    const [selectedCategories, setSelectedCategories] = useState([]);
    const [loading, setLoading] = useState(true);
    const [saving, setSaving] = useState(false);
    const [message, setMessage] = useState("");

    const fetchSources = useCallback(async () => {
        try {
            const response = await axios.get(`/api/sources`);
            setSources(response.data.sources);
            setSelectedSources(
                response.data.userSources.map((source) => source.id),
            );
        } catch (error) {
            console.error("Error fetching sources:", error);
        }
    }, []);

    const fetchCategories = useCallback(async () => {
        try {
            const response = await axios.get(`/api/categories`);
            setCategories(response.data.categories);
            setSelectedCategories(
                response.data.userCategories.map((category) => category.id),
            );
        } catch (error) {
            console.error("Error fetching categories:", error);
        }
    }, []);

    useEffect(() => {
        const fetchData = async () => {
            await fetchSources();
            await fetchCategories();
            setLoading(false);
        };
        fetchData();
    }, [fetchSources, fetchCategories]);

    const handleSourceChange = (sourceId) => {
        setSelectedSources((prevSelectedSources) =>
            prevSelectedSources.includes(sourceId)
                ? prevSelectedSources.filter((id) => id !== sourceId)
                : [...prevSelectedSources, sourceId],
        );
    };

    const handleCategoryChange = (categoryId) => {
        setSelectedCategories((prevSelectedCategories) =>
            prevSelectedCategories.includes(categoryId)
                ? prevSelectedCategories.filter((id) => id !== categoryId)
                : [...prevSelectedCategories, categoryId],
        );
    };

    const saveSources = async () => {
        try {
            await axios.post("/api/sources", { sources: selectedSources });
            setMessage("Sources saved successfully!");
        } catch (error) {
            setMessage("Error saving sources.");
        }
    };

    const saveCategories = async () => {
        try {
            await axios.post("/api/categories", {
                categories: selectedCategories,
            });
            setMessage("Categories saved successfully!");
        } catch (error) {
            setMessage("Error saving categories.");
        }
    };

    const handleSave = async () => {
        setSaving(true);
        setMessage(""); // Clear any previous messages
        try {
            if (activeTab === "sources") {
                await saveSources();
            } else if (activeTab === "categories") {
                await saveCategories();
            }
        } catch (error) {
            setMessage("Error saving settings.");
        } finally {
            setSaving(false);
            setTimeout(() => setMessage(""), 3000); // Clear message after 3 seconds
        }
    };

    if (loading) {
        return <div className="text-center mt-4">Loading...</div>;
    }

    return (
        <>
            <Header title="Settings" />
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                            <div className="flex space-x-4 mb-4">
                                <button
                                    className={`p-2 ${activeTab === "sources" ? "bg-gray-200" : ""} hover:bg-gray-300`}
                                    onClick={() => setActiveTab("sources")}
                                >
                                    Sources
                                </button>
                                <button
                                    className={`p-2 ${activeTab === "categories" ? "bg-gray-200" : ""} hover:bg-gray-300`}
                                    onClick={() => setActiveTab("categories")}
                                >
                                    Categories
                                </button>
                            </div>
                            {activeTab === "sources" && (
                                <div>
                                    <h2 className="text-xl mb-4">
                                        Select Sources
                                    </h2>
                                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                        {sources.map((source) => (
                                            <div
                                                key={source.id}
                                                className="mb-2"
                                            >
                                                <label className="flex items-center space-x-2">
                                                    <input
                                                        type="checkbox"
                                                        checked={selectedSources.includes(
                                                            source.id,
                                                        )}
                                                        onChange={() =>
                                                            handleSourceChange(
                                                                source.id,
                                                            )
                                                        }
                                                        className="hover:cursor-pointer"
                                                    />
                                                    <span>{source.name}</span>
                                                </label>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            )}
                            {activeTab === "categories" && (
                                <div>
                                    <h2 className="text-xl mb-4">
                                        Configure Categories
                                    </h2>
                                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                        {categories.map((category) => (
                                            <div
                                                key={category.id}
                                                className="mb-2"
                                            >
                                                <label className="flex items-center space-x-2">
                                                    <input
                                                        type="checkbox"
                                                        value={category.id}
                                                        checked={selectedCategories.includes(
                                                            category.id,
                                                        )}
                                                        onChange={() =>
                                                            handleCategoryChange(
                                                                category.id,
                                                            )
                                                        }
                                                        className="hover:cursor-pointer"
                                                    />
                                                    <span>{category.name}</span>
                                                </label>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            )}
                            <div className="mt-4">
                                <button
                                    className="p-2 bg-blue-500 text-white rounded hover:bg-blue-600 disabled:opacity-50"
                                    onClick={handleSave}
                                    disabled={saving}
                                >
                                    {saving ? (
                                        <span className="flex items-center">
                                            <svg
                                                className="animate-spin h-5 w-5 mr-3"
                                                viewBox="0 0 24 24"
                                            >
                                                <circle
                                                    className="opacity-25"
                                                    cx="12"
                                                    cy="12"
                                                    r="10"
                                                    stroke="currentColor"
                                                    strokeWidth="4"
                                                ></circle>
                                                <path
                                                    className="opacity-75"
                                                    fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                                ></path>
                                            </svg>
                                            Saving...
                                        </span>
                                    ) : (
                                        "Save Settings"
                                    )}
                                </button>
                                {message && (
                                    <div
                                        className={`mt-2 ${
                                            message.includes("successfully")
                                                ? "text-green-500"
                                                : "text-red-500"
                                        }`}
                                    >
                                        {message}
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default Setting;
