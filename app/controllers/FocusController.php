<?php

class FocusController extends \App\myPlugins\myController
{
    public function indexAction()
    {
        $this->view->focus = Focus::find(['order'=>'id DESC','limit'=>25]);
        
    }

    public function showAction(Focus $focus)
    {
        $this->view->focus = $focus;
    }

    public function addAction()
    {
        $data = $this->request->getPost();
        $data['page_id'] = $this->getPageIdFromUrl($data['url']);

        Focus::saveNew($data)->addMultTags($this->request->getPost('tags'));

        return $this->redirectBack();
    }

    public function deleteAction(Focus $focus)
    {
        $focus->delete();
        $this->redirectByRoute(['for'=>'focus.index']);
    }

    public function addTagAction(Focus $focus)
    {
        $tagName = $this->request->get('tag');
        $focus->addTag($tagName);
        return 'success';
    }



    private function getPageIdFromUrl($url)
    {
        if (preg_match('%http://newspaper.zhaobing/issues/([0-9]+)/page/([0-9]+)%sm', $url, $regs)) {
            $issue = $regs[1];
            $page_num = $regs[2];
            $page = Pages::findOrNewByPageNumAndIssue($issue,['page_num'=>$page_num]);
            return $page->id;
        }
        throw new Exception('没有找到对应的page_id');
    }
}
