import React from "react";

const NewsCard = ({ title, description, imageUrl, imagePayload }) => {
    let imageSrc = imageUrl;

    if (!imageSrc && imagePayload) {
        try {
            const images = JSON.parse(imagePayload);
            if (images.length > 1) {
                imageSrc = images[1].url;
            }
        } catch (error) {
            console.error("Error parsing imagePayload:", error);
        }
    }

    return (
        <div className="border rounded-lg overflow-hidden shadow-lg">
            {imageSrc ? (
                <img
                    src={imageSrc}
                    alt={title}
                    className="w-full h-48 object-cover"
                />
            ) : (
                <div className="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <span className="text-gray-500">No Image Available</span>
                </div>
            )}
            <div className="p-4">
                <h2 className="text-xl font-bold mb-2">{title}</h2>
                <p className="text-gray-700">{description}</p>
            </div>
        </div>
    );
};

export default NewsCard;
