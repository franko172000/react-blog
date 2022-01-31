import Page from "../../components/Page";
import Blog from "../../components/Blog";
import {useEffect, useState} from "react";
import {getUserPosts} from "../../services/requests";
import Loader from "../../components/Loader";

const MyBlogPosts = ()=> {
    const [posts, setPosts] = useState();
    const [showLoader, setShowLoader] = useState();
    useEffect(async ()=>{
        await getPosts();
    },[]);

    const handlePagination = async (page)=>{
        await getPosts({
            page
        });
    }

    const orderPosts = async (e)=>{
        await getPosts({
            sortOrder: e.target.value
        });
    }

    const getPosts = async (params) =>{
        setShowLoader(true);
        const res = await getUserPosts(params);
        setPosts(res.data);
        setShowLoader(false)
    }

    return (
        <>
            <Loader show={showLoader} />
            <div className="container">
                <div className="col-md-12">
                    <p>Hello Emmanuel</p>
                </div>
            </div>
            <Page
                title="My Blog Posts">
                <div className="masonry-filter-container d-flex align-items-center">
                    <span>Order by:</span>
                    <div className="col-2">
                        <select name="select" onChange={orderPosts}>
                            <option value="new">Newer Posts</option>
                            <option value="old">Older Posts</option>
                        </select>
                    </div>
                </div>
                <hr />
                <Blog onPaginationClick={handlePagination} posts={posts} />
            </Page>
        </>
    )
}

export default MyBlogPosts;
