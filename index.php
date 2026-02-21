<?php
?><!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NodeMind™ Studio</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="app-grid" id="appGrid">
  <header class="title-bar"><div>NodeMind™ Studio</div><div class="actions"><button class="btn" id="themeToggleBtn" title="Tema chiaro/scuro">☾</button><button class="btn" id="importBtn">Importa</button><button class="btn" id="exportBtn">Esporta</button><button class="btn" id="saveBtn">Salva</button></div></header>
  <div class="flows-bar" id="flowsBar"><div class="flow-tab active">Flow 1</div><button class="btn" id="addFlowBtn">+ Nuovo Flow</button><button class="btn" id="toggleQuickBar">Barra rapida</button></div>



  <div class="quickbar" id="quickBar">
    <div class="quick-group">
      <select id="quickFontFamily"><option>Inter</option><option>Segoe UI</option><option>Roboto</option><option>Courier New</option></select>
      <input type="number" id="quickFontSize" min="10" max="48" value="14" title="Dimensione testo">
      <select id="quickTextAlign"><option value="left">◧</option><option value="center" selected>☰</option><option value="right">◨</option></select>
    </div>
    <div class="quick-group">
      <label class="quick-lbl">Testo <input type="color" id="quickTextColor" value="#ffffff"></label>
      <label class="quick-lbl">Nodo <input type="color" id="quickNodeColor" value="#2f80ed"></label>
      <label class="quick-lbl">Gruppo <input type="color" id="quickGroupColor" value="#7f8c8d"></label>
          </div>
    <div class="quick-group">
      <button class="btn" id="quickCopyFormat">Copia formato</button>
      <button class="btn" id="quickPasteFormat">Incolla formato</button>
      <button class="btn" id="quickCreateGroup">Crea gruppo</button>
      <button class="btn" id="quickRemoveGroup">Rimuovi gruppo</button>
    </div>
  </div>

  <aside class="panel left-panel" id="leftPanel">
    <div class="panel-header"><strong>Palette</strong><button class="btn collapse-btn" id="toggleLeft">⇤</button><input class="search" id="paletteSearch" placeholder="Cerca palette..."><div class="palette-controls"><button class="btn" id="openAll">Apri tutto</button><button class="btn" id="closeAll">Chiudi tutto</button></div></div>
    <div class="categories" id="paletteCategories"></div>
  </aside>

  <main class="panel center-panel" id="centerPanel">
    <svg class="canvas-overlay" id="linkLayer"></svg>
    <div class="scene" id="scene"></div>
    <div id="selectionBox" class="selection-box"></div>
  </main>

  <aside class="panel right-panel" id="rightPanel">
    <div class="panel-header"><strong>Workspace</strong><button class="btn collapse-btn" id="toggleRight">⇥</button></div>
    <div class="tabs"><div class="tab active" data-tab="notes">Appunti</div><div class="tab" data-tab="mermaid">Mermaid</div><div class="tab" data-tab="properties">Proprietà</div><div class="tab" data-tab="tasks">Task</div></div>
    <div class="tab-content active lined" id="tab-notes"><textarea id="notesArea" placeholder="Scrivi appunti..."></textarea></div>
    <div class="tab-content" id="tab-mermaid">
      <textarea id="mermaidCode" placeholder="flowchart TD
A[Start] --> B[Step]"></textarea>
      <button class="btn" id="applyMermaid">Importa/Allinea Mermaid</button>
      <div class="small-note">Parser migliorato: supporta dichiarazioni separate, nodi inline nelle frecce e righe con ';'.</div>
    </div>
    <div class="tab-content" id="tab-properties">
      <button class="btn" id="openPropertiesModal">Apri finestra Proprietà</button>
      <div class="inline-props" id="inlinePropsPanel">
        <div class="small-note" id="inlinePropsTarget">Seleziona un nodo, gruppo o cavo per modificare le proprietà contestuali.</div>
        <label>Testo selezione
          <textarea id="sideTextEdit" placeholder="Testo nodo o titolo gruppo" rows="4"></textarea>
        </label>
        <label id="sideCodeWrap">Codice nodo
          <textarea id="sideCodeEdit" placeholder="Scrivi codice..." rows="6"></textarea>
        </label>
        <label id="sideHtmlWrap">HTML nodo
          <textarea id="sideHtmlEdit" placeholder="<div>...</div>" rows="6"></textarea>
        </label>
        <div class="small-note" id="sideHtmlPreview"></div>
        <label id="sideEmojiWrap">Emoticon
          <input type="text" id="sideEmojiEdit" placeholder="😀" maxlength="6">
        </label>
        <label id="sideOperatorWrap">Operatore connettore
          <select id="sideOperatorEdit"><option>+</option><option>-</option><option>*</option><option>/</option><option>AND</option><option>OR</option><option>NOT</option></select>
        </label>
        <label>Colore cavo
          <input type="color" id="sideLinkColor" value="#222222">
        </label>
        <label>Spessore cavo
          <input type="number" id="sideLinkWidth" min="1" max="12" value="2">
        </label>
        <label>Forma cavo
          <select id="sideLinkShape"><option value="curve">Tondeggiante</option><option value="orthogonal">Squadrata</option></select>
        </label>
      </div>
      <div class="small-note">Scorciatoie: Ctrl+C / Ctrl+V / Canc. Trascina sul canvas per selezione multipla.</div>
    </div>
    <div class="tab-content" id="tab-tasks"><textarea id="taskArea" placeholder="- [ ] Task 1"></textarea></div>
  </aside>

  <footer class="toolbar"><div class="zoom-controls"><button class="btn" id="zoomOut">-</button><button class="btn" id="zoomReset">100%</button><button class="btn" id="zoomIn">+</button><span id="zoomValue">100%</span></div><div>www.vr-m.it | prof. Vincenzo Rosario Mellone</div></footer>
</div>

<div class="context-menu" id="contextMenu"></div>

<div class="modal hidden" id="propertiesModal">
  <div class="modal-card">
    <div class="modal-header"><strong>Proprietà</strong><button class="btn" id="closePropertiesModal">Chiudi</button></div>
    <div class="modal-body">
      <div class="prop-section" id="nodePropSection">
      <h4>Proprietà Nodo/Cavo</h4>
      <div class="prop-grid">
        <label>Testo nodo<input type="text" id="nodeText" placeholder="Testo nodo selezionato"></label>
        <label>Colore nodo<input type="color" id="nodeColor" value="#2f80ed"></label>
        <label>Colore testo nodo<input type="color" id="nodeTextColor" value="#ffffff"></label>
        <label>Font nodo<select id="nodeFontFamily"><option>Inter</option><option>Segoe UI</option><option>Roboto</option><option>Courier New</option></select></label>
        <label>Dimensione testo nodo<input type="number" id="nodeFontSize" min="10" max="48" value="14"></label><label>Allineamento testo nodo<select id="nodeTextAlign"><option value="left">Sinistra</option><option value="center" selected>Centro</option><option value="right">Destra</option></select></label>
        <label>Colore cavo<input type="color" id="linkColor" value="#222222"></label>
        <label>Spessore cavo<input type="number" id="linkWidth" min="1" max="12" value="2"></label>
        <label>Forma cavo<select id="linkShape"><option value="curve">Tondeggiante</option><option value="orthogonal">Squadrata</option></select></label>
      </div>
      <div class="prop-actions"><button class="btn" id="applyNodeStyle">Aggiorna selezione</button><button class="btn" id="deleteSelectedLink">Elimina cavo selezionato</button><button class="btn" id="copyFormatBtn">Copia formato</button><button class="btn" id="pasteFormatBtn">Incolla formato</button></div>
      </div>
      <hr>
      <div class="prop-section" id="groupPropSection">
      <h4>Proprietà Gruppo</h4>
      <div class="prop-grid">
        <label>Titolo gruppo<input type="text" id="groupTitle" placeholder="Titolo gruppo"></label>
        <label>Colore gruppo<input type="color" id="groupColor" value="#7f8c8d"></label>
        <label>Trasparenza gruppo<input type="number" id="groupOpacity" min="0" max="1" step="0.05" value="0.2"></label>
        <label>Colore testo gruppo<input type="color" id="groupTextColor" value="#ffffff"></label>
        <label>Font gruppo<select id="groupFontFamily"><option>Inter</option><option>Segoe UI</option><option>Roboto</option><option>Courier New</option></select></label>
        <label>Dimensione titolo gruppo<input type="number" id="groupFontSize" min="10" max="42" value="14"></label><label>Allineamento titolo gruppo<select id="groupTextAlign"><option value="left">Sinistra</option><option value="center" selected>Centro</option><option value="right">Destra</option></select></label>
      </div>
      <div class="prop-actions"><button class="btn" id="createGroupBtn">Crea gruppo da selezione</button><button class="btn" id="applyGroupStyle">Aggiorna gruppo selezionato</button></div>
      </div>
      <hr>
      <div class="prop-section" id="docPropSection">
      <h4>Proprietà Documento</h4>
      <div class="prop-grid">
        <label>Font documento<select id="docFontFamily"><option>Inter</option><option>Segoe UI</option><option>Roboto</option><option>Courier New</option></select></label>
        <label>Dimensione testo documento<input type="number" id="docFontSize" min="11" max="28" value="14"></label>
        <label>Colore testo documento<input type="color" id="docTextColor" value="#e8e8e8"></label>
      </div>
      <div class="prop-actions"><button class="btn" id="applyDocStyle">Applica stile testo documento</button></div>
      </div>
    </div>
  </div>
</div>
<input type="file" id="fileInput" accept=".json,.mmd,.txt" style="display:none;">

<script>
const scene = document.getElementById('scene');
const linkLayer = document.getElementById('linkLayer');
const selectionBox = document.getElementById('selectionBox');
const contextMenu = document.getElementById('contextMenu');
const appGrid = document.getElementById('appGrid');
const centerPanel = document.getElementById('centerPanel');
const propertiesModal = document.getElementById('propertiesModal');
const themeToggleBtn = document.getElementById('themeToggleBtn');

const flows = new Map();
let currentFlow = 'Flow 1';
let selectedNodeIds = new Set();
let selectedLinkId = null;
let selectedGroupId = null;
let zoom = 1;
let draggingLink = null;
let marquee = null;
let copiedPayload = null;
let modalDrag = null;
let copiedFormat = null;
let propertiesMode = "all";
let quickBarVisible = true;
let inlineEditNodeId = null;

const paletteData = [
  { name:'Base', items:[{name:'Idea', color:'#2f80ed', type:'default'},{name:'Concetto', color:'#8e44ad', type:'default'},{name:'Nota', color:'#16a085', type:'default'}] },
  { name:'Logica', items:[{name:'Decisione', color:'#d35400'},{name:'Regola', color:'#2980b9'},{name:'Condizione', color:'#27ae60'}] },
  { name:'Output', items:[{name:'Risultato', color:'#e74c3c', type:'default'},{name:'Documento', color:'#34495e', type:'default'},{name:'Azione', color:'#7f8c8d', type:'default'}] },
  { name:'Speciali', items:[{name:'Codice', color:'#b7f5b0', type:'code'},{name:'HTML', color:'#f7c56d', type:'html'},{name:'Emoticon', color:'#8e44ad', type:'emoji'}] },
  { name:'Flowchart', items:[{name:'If', color:'#f1c40f', type:'if'},{name:'Attività', color:'#3498db', type:'activity'},{name:'In/Out', color:'#1abc9c', type:'inout'},{name:'Connettore', color:'#95a5a6', type:'connector'}] }
];

function uid(prefix='n'){ return prefix + Math.random().toString(36).slice(2,9); }
function nodeDefaultsByType(type='default'){
  if(type === 'code') return {type, color:'#b7f5b0', fontFamily:'monospace', fontSize:13, textColor:'#1b5e20', textAlign:'left', label:'// codice\n', lockFont:true};
  if(type === 'html') return {type, color:'#f7c56d', fontFamily:'Inter', fontSize:13, textColor:'#1f1f1f', textAlign:'left', label:'<b>HTML</b>'};
  if(type === 'emoji') return {type, color:'#8e44ad', fontFamily:'Inter', fontSize:26, textColor:'#ffffff', textAlign:'center', label:'😀'};
  if(type === 'if') return {type, color:'#f1c40f', fontFamily:'Inter', fontSize:14, textColor:'#1f1f1f', textAlign:'center', label:'Condizione?'};
  if(type === 'activity') return {type, color:'#3498db', fontFamily:'Inter', fontSize:14, textColor:'#ffffff', textAlign:'center', label:'Attività'};
  if(type === 'inout') return {type, color:'#1abc9c', fontFamily:'Inter', fontSize:14, textColor:'#ffffff', textAlign:'center', label:'Input/Output'};
  if(type === 'connector') return {type, color:'#95a5a6', fontFamily:'Inter', fontSize:14, textColor:'#111111', textAlign:'center', label:'+', operator:'+'};
  return {type:'default'};
}
function initFlow(name){
  if(!flows.has(name)) flows.set(name, {nodes:[],links:[],groups:[],notes:'',tasks:'',docStyle:{fontFamily:'Inter',fontSize:14,textColor:'#e8e8e8'}});
  const f = flows.get(name);
  if(!f.groups) f.groups = [];
  if(!f.docStyle) f.docStyle = {fontFamily:'Inter',fontSize:14,textColor:'#e8e8e8'};
}
function getFlow(){ initFlow(currentFlow); return flows.get(currentFlow); }

function portSidesForNode(node){
  if(node.type === 'if') return ['left','right'];
  return ['left','right','top','bottom'];
}

function measureNodeWidth(node){
  if(node.type === 'connector') return 78;
  if(node.type === 'if') return 170;
  if(node.type === 'code') return 300;
  const lines = String(node.label || '').split('\n');
  const longest = Math.max(...lines.map(l => l.length), 6);
  return Math.min(340, Math.max(140, longest * ((node.fontSize || 14) * 0.62)));
}
function measureNodeHeight(node){
  if(node.type === 'connector') return 78;
  if(node.type === 'if') return 110;
  if(node.type === 'code') return Math.max(110, 30 + String(node.label || '').split('\n').length * 18);
  const lines = String(node.label || '').split('\n').length;
  return Math.max(48, 20 + lines * ((node.fontSize || 14) * 1.35));
}
function toRgba(hex, alpha){
  const clean = hex.replace('#','');
  const full = clean.length === 3 ? clean.split('').map(c=>c+c).join('') : clean;
  const r = parseInt(full.slice(0,2),16), g = parseInt(full.slice(2,4),16), b = parseInt(full.slice(4,6),16);
  return `rgba(${r}, ${g}, ${b}, ${Math.max(0, Math.min(1, Number(alpha || 0.2)))})`;
}

function renderPalette(){
  const term = paletteSearch.value.toLowerCase();
  paletteCategories.innerHTML = '';
  paletteData.forEach(cat => {
    const items = cat.items.filter(i => i.name.toLowerCase().includes(term) || cat.name.toLowerCase().includes(term));
    if(!items.length) return;
    const block = document.createElement('div');
    block.className = 'category';
    block.innerHTML = `<h4 class="cat-title"><span>${cat.name}</span><span>▾</span></h4><div class="cat-items"></div>`;
    block.querySelector('.cat-title').onclick = () => block.classList.toggle('collapsed');
    const list = block.querySelector('.cat-items');
    items.forEach(item => {
      const row = document.createElement('div');
      row.className = 'palette-item';
      row.draggable = true;
      row.innerHTML = `<span class="palette-swatch" style="background:${item.color}"></span><span class="palette-item-name">${item.name}</span><div class="palette-item-tools"><input class="inline-color" type="color" value="${item.color}"><button class="mini-btn">+</button></div>`;
      row.addEventListener('dragstart', e => e.dataTransfer.setData('application/json', JSON.stringify(item)));
      row.onclick = (e) => {
        if(e.target.closest('.palette-item-tools')) return;
        const special = ['code','html','emoji','if','activity','inout','connector'].includes(item.type || '');
        addNode({label:special ? undefined : item.name,color:item.color,x:80,y:80,type:item.type || 'default'});
      };
      row.querySelector('.inline-color').oninput = (e) => { item.color = e.target.value; row.querySelector('.palette-swatch').style.background = item.color; };
      row.querySelector('.mini-btn').onclick = (e) => {
        e.stopPropagation();
        const special = ['code','html','emoji','if','activity','inout','connector'].includes(item.type || '');
        addNode({label:special ? undefined : item.name,color:item.color,x:100,y:100,type:item.type || 'default'});
      };
      list.appendChild(row);
    });
    paletteCategories.appendChild(block);
  });
}

function addNode({id=uid(),label=null,color=null,x=80,y=80,fontSize=14,fontFamily='Inter',textColor='#ffffff',textAlign='center',type='default',operator='+'}){
  const flow = getFlow();
  const defaults = nodeDefaultsByType(type);
  const step = flow.nodes.length % 6;
  const yy = y + Math.floor(flow.nodes.length / 6) * 90;
  flow.nodes.push({
    id,
    label: label ?? defaults.label ?? 'Nodo',
    color: color ?? defaults.color ?? '#2f80ed',
    x: x + step * 36,y: yy,
    fontSize: defaults.fontSize ?? fontSize,
    fontFamily: defaults.fontFamily ?? fontFamily,
    textColor: defaults.textColor ?? textColor,
    textAlign: defaults.textAlign ?? textAlign,
    type: defaults.type || type,
    lockFont: defaults.lockFont || false,
    operator: defaults.operator || operator
  });
  selectedNodeIds = new Set([id]);
  renderScene();
  updateMermaid();
}

function portPos(node, side){
  const w = measureNodeWidth(node), h = measureNodeHeight(node);
  if(side === 'left') return {x: node.x, y: node.y + h/2};
  if(side === 'right') return {x: node.x + w, y: node.y + h/2};
  if(side === 'top') return {x: node.x + w/2, y: node.y};
  return {x: node.x + w/2, y: node.y + h};
}

function recomputeGroups(){
  const flow = getFlow();
  flow.groups.forEach(group => {
    const nodes = flow.nodes.filter(n => group.nodeIds.includes(n.id));
    if(!nodes.length) return;
    const left = Math.min(...nodes.map(n => n.x));
    const top = Math.min(...nodes.map(n => n.y));
    const right = Math.max(...nodes.map(n => n.x + measureNodeWidth(n)));
    const bottom = Math.max(...nodes.map(n => n.y + measureNodeHeight(n)));
    group.x = left - 18; group.y = top - 34; group.w = (right - left) + 36; group.h = (bottom - top) + 52;
  });
}

function renderGroups(){
  const flow = getFlow();
  flow.groups.forEach(group => {
    const el = document.createElement('div');
    el.className = 'node-group' + (selectedGroupId === group.id ? ' selected' : '');
    el.style.left = group.x + 'px';
    el.style.top = group.y + 'px';
    el.style.width = group.w + 'px';
    el.style.height = group.h + 'px';
    el.style.background = toRgba(group.color || '#7f8c8d', group.opacity ?? 0.2);
    el.style.borderColor = group.color || '#7f8c8d';

    const title = document.createElement('div');
    title.className = 'group-title';
    title.textContent = group.title || 'Gruppo';
    title.style.color = group.textColor || '#fff';
    title.style.fontSize = (group.fontSize || 14) + 'px';
    title.style.fontFamily = group.fontFamily || 'Inter';
    title.style.textAlign = group.textAlign || 'center';
    el.appendChild(title);

    el.onclick = (e) => { e.stopPropagation(); selectedGroupId = group.id; selectedLinkId = null; selectedNodeIds.clear(); fillGroupInputs(group); setPropertiesMode('group'); renderScene(); };
    el.onmousedown = (e) => { if(e.button!==0) return; e.stopPropagation(); startGroupDrag(e, group.id); };
    el.oncontextmenu = (e) => { e.preventDefault(); showGroupMenu(e.clientX, e.clientY, group.id); };
    scene.appendChild(el);
  });
}

function renderNodes(){
  const flow = getFlow();
  flow.nodes.forEach(nodeData => {
    const node = document.createElement('div');
    node.className = 'node' + (selectedNodeIds.has(nodeData.id) ? ' selected' : '');
    if(nodeData.type) node.classList.add('type-' + nodeData.type);
    node.dataset.id = nodeData.id;
    node.style.left = nodeData.x + 'px';
    node.style.top = nodeData.y + 'px';
    node.style.background = nodeData.color;
    node.style.color = nodeData.textColor || '#fff';
    node.style.fontFamily = nodeData.lockFont ? 'monospace' : (nodeData.fontFamily || 'Inter');
    node.style.fontSize = (nodeData.fontSize || 14) + 'px';
    node.style.width = measureNodeWidth(nodeData) + 'px';
    node.style.textAlign = nodeData.textAlign || 'center';

    const label = document.createElement('div');
    label.className = 'node-label';
    if(nodeData.type === 'html') label.innerHTML = nodeData.label;
    else label.textContent = nodeData.label;
    if(nodeData.type === 'if') label.classList.add('diamond-text');
    node.appendChild(label);

    const toolbar = document.createElement('div');
    toolbar.className = 'node-toolbar';
    toolbar.innerHTML = '<button class="mini-btn" data-act="dup">Dup</button><button class="mini-btn" data-act="del">Del</button>';
    node.appendChild(toolbar);

    portSidesForNode(nodeData).forEach(side => {
      const p = document.createElement('span');
      p.className = 'port ' + side;
      p.dataset.nodeId = nodeData.id;
      p.dataset.side = side;
      p.onpointerdown = (e) => startLinkDrag(e, nodeData.id, side);
      p.onmousedown = (e) => startLinkDrag(e, nodeData.id, side);
      node.appendChild(p);
      if(nodeData.type === 'if' && (side === 'left' || side === 'right')){
        const tag = document.createElement('span');
        tag.className = 'port-tag ' + side;
        tag.textContent = side === 'right' ? 'Vero' : 'Falso';
        node.appendChild(tag);
      }
    });

    node.onmousedown = (e) => {
      if(e.detail > 1 || e.target.classList.contains('port') || e.target.closest('.node-toolbar')) return;
      let changed = false;
      if(e.shiftKey || e.ctrlKey || e.metaKey){
        if(selectedNodeIds.has(nodeData.id)) selectedNodeIds.delete(nodeData.id); else selectedNodeIds.add(nodeData.id);
        changed = true;
      } else if(!selectedNodeIds.has(nodeData.id)) {
        selectedNodeIds = new Set([nodeData.id]);
        changed = true;
      }
      if(selectedGroupId || selectedLinkId){
        selectedGroupId = null;
        selectedLinkId = null;
        changed = true;
      }
      fillNodeInputsFromSelection();
      setPropertiesMode('node');
      startNodeDrag(e, nodeData.id);
      if(changed) renderScene();
    };

    node.ondblclick = (e) => {
      if(e.target.classList.contains('port')) return;
      e.stopPropagation();
      selectSingleNode(nodeData.id);
      requestAnimationFrame(() => {
        const fresh = scene.querySelector(`.node[data-id="${nodeData.id}"]`);
        if(fresh) startInlineEdit(fresh, nodeData);
      });
    };

    node.oncontextmenu = (e) => { e.preventDefault(); showNodeMenu(e.clientX, e.clientY, nodeData.id); };

    node.querySelector('[data-act="dup"]').onclick = (e) => { e.stopPropagation(); addNode({label:nodeData.label,color:nodeData.color,x:nodeData.x+24,y:nodeData.y+24,fontSize:nodeData.fontSize||14,fontFamily:nodeData.fontFamily||'Inter',textColor:nodeData.textColor||'#fff',textAlign:nodeData.textAlign||'center',type:nodeData.type||'default',operator:nodeData.operator||'+'}); };
    node.querySelector('[data-act="del"]').onclick = (e) => { e.stopPropagation(); deleteNodes([nodeData.id]); };
    scene.appendChild(node);
  });
}


function selectSingleNode(id){
  selectedNodeIds = new Set([id]);
  selectedGroupId = null;
  selectedLinkId = null;
  fillNodeInputsFromSelection();
  renderScene();
}

function renderScene(){
  scene.innerHTML = '';
  recomputeGroups();
  renderGroups();
  renderNodes();
  drawLinks();
  applyZoom();
  updateInlinePropsPanel();
}

function startInlineEdit(nodeEl, nodeData){
  if(nodeData.type === 'connector') return;
  inlineEditNodeId = nodeData.id;
  const label = nodeEl.querySelector('.node-label');
  label.contentEditable = 'true';
  label.classList.add('editing');
  label.spellcheck = false;
  label.onmousedown = (e) => e.stopPropagation();
  label.focus();

  const finish = (cancel=false) => {
    if(inlineEditNodeId !== nodeData.id) return;
    inlineEditNodeId = null;
    label.contentEditable = 'false';
    label.classList.remove('editing');
    if(cancel) label[nodeData.type === 'html' ? 'innerHTML' : 'textContent'] = nodeData.label;
    nodeData.label = (nodeData.type === 'html' ? label.innerHTML : label.textContent).replace(/\r/g, '');
    updateMermaid();
    renderScene();
  };

  label.onkeydown = (ev) => {
    if(ev.key === 'Escape'){ ev.preventDefault(); finish(true); }
    if(ev.key === 'Enter' && (ev.ctrlKey || ev.metaKey)){ ev.preventDefault(); finish(false); }
  };
  label.onblur = () => finish(false);
}

function startLinkDrag(ev, nodeId, side){
  ev.stopPropagation();
  ev.preventDefault();
  const node = getFlow().nodes.find(n => n.id === nodeId);
  if(!node) return;
  const start = portPos(node, side);
  draggingLink = { from: nodeId, fromSide: side, x: start.x, y: start.y, toX: start.x, toY: start.y };
  drawLinks();
}

scene.addEventListener('pointermove', (ev) => {
  if(draggingLink){
    const rect = scene.getBoundingClientRect();
    draggingLink.toX = (ev.clientX - rect.left) / zoom;
    draggingLink.toY = (ev.clientY - rect.top) / zoom;
    drawLinks();
  }
  if(marquee){
    updateMarquee(ev.clientX, ev.clientY);
  }
});

document.addEventListener('pointerup', (ev) => {
  if(draggingLink){
    const stack = document.elementsFromPoint(ev.clientX, ev.clientY);
    const target = stack.find(el => el.classList?.contains('port')) || stack.find(el => el.classList?.contains('node')) || stack[0];
    let toNodeId = null;
    let toSide = null;
    if(target && target.classList.contains('port')){
      toNodeId = target.dataset.nodeId;
      toSide = target.dataset.side;
    } else if(target){
      const nodeEl = target.closest('.node');
      if(nodeEl){
        toNodeId = nodeEl.dataset.id;
        const nodeData = getFlow().nodes.find(n => n.id === toNodeId);
        const sides = nodeData ? portSidesForNode(nodeData) : ['left','right'];
        const fromSide = draggingLink.fromSide || 'right';
        if(sides.includes('left') && fromSide === 'right') toSide = 'left';
        else if(sides.includes('right') && fromSide === 'left') toSide = 'right';
        else toSide = sides.includes('left') ? 'left' : (sides[0] || 'right');
      }
    }
    if(toNodeId && toNodeId !== draggingLink.from){
      const flow = getFlow();
      flow.links.push({id:uid('l'),from:draggingLink.from,to:toNodeId,fromSide:draggingLink.fromSide,toSide:toSide || 'left',color:'#222222',width:2,shape:'curve'});
      selectedLinkId = flow.links[flow.links.length-1].id;
      selectedNodeIds.clear(); selectedGroupId = null;
      updateMermaid();
    }
    draggingLink = null;
    renderScene();
  }
  if(marquee) endMarquee();
});

function drawCurve(x1,y1,x2,y2){ const cx=(x1+x2)/2; return `M ${x1} ${y1} C ${cx} ${y1}, ${cx} ${y2}, ${x2} ${y2}`; }
function drawOrthogonal(x1,y1,x2,y2){ const mid=(x1+x2)/2; return `M ${x1} ${y1} L ${mid} ${y1} L ${mid} ${y2} L ${x2} ${y2}`; }

function pointSegDist(px,py,x1,y1,x2,y2){
  const dx = x2 - x1, dy = y2 - y1;
  if(dx === 0 && dy === 0) return Math.hypot(px - x1, py - y1);
  const t = Math.max(0, Math.min(1, ((px-x1)*dx + (py-y1)*dy) / (dx*dx + dy*dy)));
  const cx = x1 + t*dx, cy = y1 + t*dy;
  return Math.hypot(px-cx, py-cy);
}

function bezierPoint(t, p0, p1, p2, p3){
  const u = 1 - t;
  const tt = t*t, uu = u*u;
  const uuu = uu*u, ttt = tt*t;
  return {
    x: (uuu*p0.x) + (3*uu*t*p1.x) + (3*u*tt*p2.x) + (ttt*p3.x),
    y: (uuu*p0.y) + (3*uu*t*p1.y) + (3*u*tt*p2.y) + (ttt*p3.y)
  };
}

function linkDistanceToPoint(link, x, y){
  const flow = getFlow();
  const from = flow.nodes.find(n => n.id === link.from);
  const to = flow.nodes.find(n => n.id === link.to);
  if(!from || !to) return Infinity;
  const p1 = portPos(from, link.fromSide || 'right');
  const p2 = portPos(to, link.toSide || 'left');

  if((link.shape || 'curve') === 'orthogonal'){
    const mid = (p1.x + p2.x) / 2;
    return Math.min(
      pointSegDist(x,y,p1.x,p1.y,mid,p1.y),
      pointSegDist(x,y,mid,p1.y,mid,p2.y),
      pointSegDist(x,y,mid,p2.y,p2.x,p2.y)
    );
  }

  const cx = (p1.x + p2.x)/2;
  const c1 = {x:cx, y:p1.y}, c2 = {x:cx, y:p2.y};
  let min = Infinity;
  let prev = p1;
  for(let i=1;i<=20;i++){
    const t = i/20;
    const pt = bezierPoint(t, p1, c1, c2, p2);
    min = Math.min(min, pointSegDist(x,y,prev.x,prev.y,pt.x,pt.y));
    prev = pt;
  }
  return min;
}

function drawLinks(){
  const flow = getFlow();
  const nodesById = Object.fromEntries(flow.nodes.map(n => [n.id, n]));
  linkLayer.innerHTML = '';
  linkLayer.setAttribute('width', scene.clientWidth);
  linkLayer.setAttribute('height', scene.clientHeight);

  flow.links.forEach(link => {
    const from = nodesById[link.from], to = nodesById[link.to];
    if(!from || !to) return;
    const p1 = portPos(from, link.fromSide || 'right');
    const p2 = portPos(to, link.toSide || 'left');
    const hitPath = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    hitPath.setAttribute('data-link-id', link.id);
    path.setAttribute('data-link-id', link.id);
    path.classList.add('link-path');
    if(selectedLinkId === link.id) path.classList.add('selected');
    const shape = link.shape || 'curve';
    const d = shape === 'orthogonal' ? drawOrthogonal(p1.x*zoom,p1.y*zoom,p2.x*zoom,p2.y*zoom) : drawCurve(p1.x*zoom,p1.y*zoom,p2.x*zoom,p2.y*zoom);
    hitPath.setAttribute('d', d);
    path.setAttribute('d', d);
    path.setAttribute('stroke', link.color || '#222');
    path.setAttribute('stroke-width', String(link.width || 2));
    path.setAttribute('stroke-linecap', 'round');
    hitPath.setAttribute('fill', 'none');
    hitPath.setAttribute('stroke', 'rgba(0,0,0,0.001)');
    hitPath.setAttribute('stroke-width', String(Math.max(12, Number(link.width || 2) + 8)));
    hitPath.classList.add('link-hit-path');
    hitPath.style.pointerEvents = 'stroke';
    hitPath.style.cursor = 'pointer';
    const selectLink = (e) => {
      e.stopPropagation();
      selectedLinkId = link.id;
      selectedNodeIds.clear();
      selectedGroupId = null;
      setPropertiesMode('link');
      linkColor.value = link.color || '#222222';
      linkWidth.value = String(link.width || 2);
      linkShape.value = link.shape || 'curve';
      renderScene();
    };
    path.onclick = selectLink;
    hitPath.onclick = selectLink;
    hitPath.oncontextmenu = (e) => {
      e.preventDefault();
      selectLink(e);
      showLinkMenu(e.clientX, e.clientY, link.id);
    };
    linkLayer.appendChild(hitPath);
    linkLayer.appendChild(path);
  });

  if(draggingLink){
    const dragPath = document.createElementNS('http://www.w3.org/2000/svg','path');
    dragPath.classList.add('link-path','dragging');
    dragPath.setAttribute('d', drawCurve(draggingLink.x*zoom,draggingLink.y*zoom,draggingLink.toX*zoom,draggingLink.toY*zoom));
    dragPath.setAttribute('stroke', '#666');
    dragPath.setAttribute('stroke-width', '2');
    linkLayer.appendChild(dragPath);
  }
}

function startNodeDrag(e, anchorNodeId){
  const flow = getFlow();
  const selected = flow.nodes.filter(n => selectedNodeIds.has(n.id));
  const start = {x:e.clientX, y:e.clientY};
  const originals = selected.map(n => ({id:n.id,x:n.x,y:n.y}));
  document.onmousemove = (mv) => {
    const dx = (mv.clientX - start.x) / zoom;
    const dy = (mv.clientY - start.y) / zoom;
    originals.forEach(o => {
      const node = flow.nodes.find(n => n.id === o.id);
      if(node){ node.x = o.x + dx; node.y = o.y + dy; }
    });
    renderScene();
  };
  document.onmouseup = () => { document.onmousemove = null; document.onmouseup = null; updateMermaid(); };
}


function startGroupDrag(e, groupId){
  const flow = getFlow();
  const group = flow.groups.find(g => g.id === groupId);
  if(!group) return;
  selectedGroupId = groupId;
  const nodes = flow.nodes.filter(n => group.nodeIds.includes(n.id));
  const startX = e.clientX, startY = e.clientY;
  const originals = nodes.map(n => ({id:n.id,x:n.x,y:n.y}));
  document.onmousemove = (mv) => {
    const dx = (mv.clientX - startX) / zoom;
    const dy = (mv.clientY - startY) / zoom;
    originals.forEach(o => {
      const n = flow.nodes.find(x => x.id === o.id);
      if(n){ n.x = o.x + dx; n.y = o.y + dy; }
    });
    renderScene();
  };
  document.onmouseup = () => { document.onmousemove = null; document.onmouseup = null; updateMermaid(); };
}

function startMarquee(clientX, clientY){
  const rect = scene.getBoundingClientRect();
  marquee = {x0:clientX - rect.left, y0:clientY - rect.top, x1:clientX - rect.left, y1:clientY - rect.top};
  selectionBox.style.display = 'block';
  updateMarquee(clientX, clientY);
}
function updateMarquee(clientX, clientY){
  const rect = scene.getBoundingClientRect();
  marquee.x1 = clientX - rect.left;
  marquee.y1 = clientY - rect.top;
  const x = Math.min(marquee.x0, marquee.x1), y = Math.min(marquee.y0, marquee.y1);
  const w = Math.abs(marquee.x1 - marquee.x0), h = Math.abs(marquee.y1 - marquee.y0);
  selectionBox.style.left = x + 'px'; selectionBox.style.top = y + 'px'; selectionBox.style.width = w + 'px'; selectionBox.style.height = h + 'px';

  const flow = getFlow();
  const selected = flow.nodes.filter(n => {
    const nx = n.x*zoom, ny=n.y*zoom, nw = measureNodeWidth(n)*zoom, nh = measureNodeHeight(n)*zoom;
    return nx >= x && ny >= y && (nx+nw) <= (x+w) && (ny+nh) <= (y+h);
  }).map(n => n.id);
  selectedNodeIds = new Set(selected);
  selectedGroupId = null; selectedLinkId = null;
  fillNodeInputsFromSelection();
  renderScene();
}
function endMarquee(){ marquee = null; selectionBox.style.display = 'none'; }

centerPanel.addEventListener('mousedown', (e) => {
  if(e.target.closest('.node') || e.target.closest('.port') || e.target.closest('.node-group') || e.target.closest('#selectionBox')) return;
  if(e.button !== 0) return;
  selectedNodeIds.clear(); selectedGroupId = null; selectedLinkId = null;
  startMarquee(e.clientX, e.clientY);
});

function deleteNodes(ids){
  const flow = getFlow();
  const idSet = new Set(ids);
  flow.nodes = flow.nodes.filter(n => !idSet.has(n.id));
  flow.links = flow.links.filter(l => !idSet.has(l.from) && !idSet.has(l.to));
  flow.groups = flow.groups.map(g => ({...g, nodeIds: g.nodeIds.filter(id => !idSet.has(id))})).filter(g => g.nodeIds.length > 0);
  selectedNodeIds.clear();
  updateMermaid();
  renderScene();
}
function deleteSelectedLinkFn(){
  if(!selectedLinkId) return;
  const flow = getFlow();
  flow.links = flow.links.filter(l => l.id !== selectedLinkId);
  selectedLinkId = null;
  updateMermaid();
  renderScene();
}
function deleteSelectedGroup(){
  if(!selectedGroupId) return;
  const flow = getFlow();
  flow.groups = flow.groups.filter(g => g.id !== selectedGroupId);
  selectedGroupId = null;
  updateMermaid();
  renderScene();
}

function copySelectedNodes(){
  const flow = getFlow();
  const nodes = flow.nodes.filter(n => selectedNodeIds.has(n.id));
  if(!nodes.length) return;
  const minX = Math.min(...nodes.map(n => n.x));
  const minY = Math.min(...nodes.map(n => n.y));
  const nodeIds = new Set(nodes.map(n => n.id));
  const links = flow.links.filter(l => nodeIds.has(l.from) && nodeIds.has(l.to));
  copiedPayload = { nodes: nodes.map(n => ({...n, x:n.x-minX, y:n.y-minY})), links: links.map(l => ({...l})) };
}
function pasteNodes(){
  if(!copiedPayload) return;
  const flow = getFlow();
  const mapOldNew = new Map();
  const offsetX = 40, offsetY = 40;
  copiedPayload.nodes.forEach(n => {
    const id = uid();
    mapOldNew.set(n.id,id);
    flow.nodes.push({...n,id,x:n.x+offsetX,y:n.y+offsetY});
  });
  copiedPayload.links.forEach(l => {
    flow.links.push({...l,id:uid('l'),from:mapOldNew.get(l.from),to:mapOldNew.get(l.to)});
  });
  selectedNodeIds = new Set(Array.from(mapOldNew.values()));
  updateMermaid();
  renderScene();
}

function createGroupFromSelection(){
  const ids = Array.from(selectedNodeIds);
  if(ids.length < 2) return alert('Seleziona almeno 2 nodi per creare un gruppo.');
  const flow = getFlow();
  const group = {
    id: uid('g'),
    title: groupTitle.value || 'Nuovo Gruppo',
    color: groupColor.value,
    opacity: Number(groupOpacity.value || 0.2),
    textColor: groupTextColor.value,
    fontFamily: groupFontFamily.value || 'Inter',
    fontSize: Number(groupFontSize.value || 14),
    textAlign: groupTextAlign.value || 'center',
    nodeIds: ids,
    x:0,y:0,w:120,h:120
  };
  flow.groups.push(group);
  selectedGroupId = group.id;
  selectedNodeIds.clear();
  recomputeGroups();
  updateMermaid();
  renderScene();
}
function fillGroupInputs(group){
  groupTitle.value = group.title || '';
  groupColor.value = group.color || '#7f8c8d';
  groupOpacity.value = group.opacity ?? 0.2;
  groupTextColor.value = group.textColor || '#ffffff';
  groupFontFamily.value = group.fontFamily || 'Inter';
  groupFontSize.value = group.fontSize || 14;
  groupTextAlign.value = group.textAlign || 'center';
  quickGroupColor.value = group.color || '#7f8c8d';
  quickFontFamily.value = group.fontFamily || 'Inter';
  quickFontSize.value = group.fontSize || 14;
  quickTextColor.value = group.textColor || '#ffffff';
  quickTextAlign.value = group.textAlign || 'center';
}
function applyGroupStyleFn(){
  if(!selectedGroupId) return;
  const flow = getFlow();
  const group = flow.groups.find(g => g.id === selectedGroupId);
  if(!group) return;
  group.title = groupTitle.value || group.title;
  group.color = groupColor.value;
  group.opacity = Number(groupOpacity.value || 0.2);
  group.textColor = groupTextColor.value;
  group.fontFamily = groupFontFamily.value || 'Inter';
  group.fontSize = Number(groupFontSize.value || 14);
  group.textAlign = groupTextAlign.value || 'center';
  updateMermaid();
  renderScene();
}

function fillNodeInputsFromSelection(){
  const flow = getFlow();
  const first = flow.nodes.find(n => selectedNodeIds.has(n.id));
  if(!first) return;
  nodeText.value = first.label || '';
  nodeColor.value = first.color || '#2f80ed';
  nodeTextColor.value = first.textColor || '#ffffff';
  nodeFontFamily.value = first.lockFont ? 'Courier New' : (first.fontFamily || 'Inter');
  nodeFontSize.value = first.fontSize || 14;
  nodeTextAlign.value = first.textAlign || 'center';
  quickFontFamily.value = first.fontFamily || 'Inter';
  quickFontSize.value = first.fontSize || 14;
  quickTextColor.value = first.textColor || '#ffffff';
  quickNodeColor.value = first.color || '#2f80ed';
  quickTextAlign.value = first.textAlign || 'center';
}

function showNodeMenu(x,y,nodeId){
  const flow = getFlow();
  const node = flow.nodes.find(n => n.id === nodeId);
  if(!node) return;
  contextMenu.innerHTML = '';
  const addItem = (label, fn) => {
    const btn = document.createElement('button');
    btn.textContent = label;
    btn.onclick = () => { fn(); hideMenu(); };
    contextMenu.appendChild(btn);
  };
  addItem('Proprietà', () => { selectSingleNode(nodeId); openPropertiesModalFor('node'); });
  addItem('Rinomina (inline)', () => { const el = scene.querySelector(`.node[data-id="${nodeId}"]`); if(el) startInlineEdit(el, node); });
  addItem('Duplica nodo', () => addNode({label:node.label,color:node.color,x:node.x+24,y:node.y+24,fontSize:node.fontSize,fontFamily:node.fontFamily,textColor:node.textColor}));
  addItem('Seleziona nodi stesso gruppo', () => {
    const g = flow.groups.find(gr => gr.nodeIds.includes(nodeId));
    if(g) selectedNodeIds = new Set(g.nodeIds);
    renderScene();
  });
  addItem('Rimuovi da gruppo', () => {
    flow.groups.forEach(g => g.nodeIds = g.nodeIds.filter(id => id !== nodeId));
    flow.groups = flow.groups.filter(g => g.nodeIds.length > 0);
    updateMermaid(); renderScene();
  });
  addItem('Elimina nodo', () => deleteNodes([nodeId]));
  contextMenu.style.left = x + 'px';
  contextMenu.style.top = y + 'px';
  contextMenu.style.display = 'block';
}

function showGroupMenu(x,y,groupId){
  const flow = getFlow();
  const group = flow.groups.find(g => g.id === groupId);
  if(!group) return;
  contextMenu.innerHTML = '';
  const addItem = (label, fn) => {
    const btn = document.createElement('button');
    btn.textContent = label;
    btn.onclick = () => { fn(); hideMenu(); };
    contextMenu.appendChild(btn);
  };
  addItem('Proprietà gruppo', () => { selectedGroupId = groupId; selectedNodeIds.clear(); fillGroupInputs(group); openPropertiesModalFor('group'); renderScene(); });
  addItem('Elimina gruppo', () => { selectedGroupId = groupId; deleteSelectedGroup(); });
  contextMenu.style.left = x + 'px';
  contextMenu.style.top = y + 'px';
  contextMenu.style.display = 'block';
}

function showLinkMenu(x,y,linkId){
  contextMenu.innerHTML = '';
  const addItem = (label, fn) => {
    const btn = document.createElement('button');
    btn.textContent = label;
    btn.onclick = () => { fn(); hideMenu(); };
    contextMenu.appendChild(btn);
  };
  addItem('Proprietà cavo', () => {
    selectedLinkId = linkId;
    selectedNodeIds.clear();
    selectedGroupId = null;
    setPropertiesMode('link');
    openPropertiesModalFor('link');
  });
  addItem('Elimina cavo', () => {
    selectedLinkId = linkId;
    deleteSelectedLinkFn();
  });
  contextMenu.style.left = x + 'px';
  contextMenu.style.top = y + 'px';
  contextMenu.style.display = 'block';
}

function setPropertiesMode(mode){
  propertiesMode = mode;
  nodePropSection.style.display = (mode === 'all' || mode === 'node' || mode === 'link') ? 'block' : 'none';
  groupPropSection.style.display = (mode === 'all' || mode === 'group') ? 'block' : 'none';
  docPropSection.style.display = (mode === 'all' || mode === 'doc') ? 'block' : 'none';
}

function updateInlinePropsPanel(){
  const flow = getFlow();
  const target = document.getElementById('inlinePropsTarget');
  const textArea = document.getElementById('sideTextEdit');
  const codeWrap = document.getElementById('sideCodeWrap');
  const codeEdit = document.getElementById('sideCodeEdit');
  const htmlWrap = document.getElementById('sideHtmlWrap');
  const htmlEdit = document.getElementById('sideHtmlEdit');
  const htmlPreview = document.getElementById('sideHtmlPreview');
  const emojiWrap = document.getElementById('sideEmojiWrap');
  const emojiEdit = document.getElementById('sideEmojiEdit');
  const opWrap = document.getElementById('sideOperatorWrap');
  const opEdit = document.getElementById('sideOperatorEdit');
  const sideColor = document.getElementById('sideLinkColor');
  const sideWidth = document.getElementById('sideLinkWidth');
  const sideShape = document.getElementById('sideLinkShape');

  [codeWrap, htmlWrap, htmlPreview, emojiWrap, opWrap].forEach(el => el.style.display = 'none');

  if(selectedLinkId){
    const l = flow.links.find(v => v.id === selectedLinkId);
    if(!l) return;
    target.textContent = 'Selezionato: cavo';
    textArea.value = '';
    textArea.disabled = true;
    sideColor.disabled = false;
    sideWidth.disabled = false;
    sideShape.disabled = false;
    sideColor.value = l.color || '#222222';
    sideWidth.value = String(l.width || 2);
    sideShape.value = l.shape || 'curve';
    return;
  }

  sideColor.disabled = true;
  sideWidth.disabled = true;
  sideShape.disabled = true;

  if(selectedGroupId){
    const g = flow.groups.find(v => v.id === selectedGroupId);
    target.textContent = 'Selezionato: gruppo';
    textArea.disabled = false;
    textArea.value = g?.title || '';
    return;
  }
  if(selectedNodeIds.size === 1){
    const n = flow.nodes.find(v => selectedNodeIds.has(v.id));
    target.textContent = 'Selezionato: nodo';
    textArea.disabled = false;
    textArea.value = n?.label || '';
    if(n?.type === 'code'){
      codeWrap.style.display = 'grid';
      codeEdit.value = n.label || '';
    }
    if(n?.type === 'html'){
      htmlWrap.style.display = 'grid';
      htmlPreview.style.display = 'block';
      htmlEdit.value = n.label || '';
      htmlPreview.innerHTML = '<strong>Preview:</strong><div>' + (n.label || '') + '</div>';
    }
    if(n?.type === 'emoji'){
      emojiWrap.style.display = 'grid';
      emojiEdit.value = n.label || '';
    }
    if(n?.type === 'connector'){
      opWrap.style.display = 'grid';
      opEdit.value = n.operator || n.label || '+';
    }
    return;
  }
  target.textContent = selectedNodeIds.size > 1 ? `Selezionati: ${selectedNodeIds.size} nodi` : 'Seleziona un nodo, gruppo o cavo per modificare le proprietà contestuali.';
  textArea.disabled = selectedNodeIds.size !== 1;
  textArea.value = '';
}

function openPropertiesModalFor(mode='all'){
  setPropertiesMode(mode);
  propertiesModal.classList.remove('hidden');
}

function rgbFromHex(hex){
  const c = hex.replace('#','');
  const full = c.length===3 ? c.split('').map(x=>x+x).join('') : c;
  const r = parseInt(full.slice(0,2),16), g=parseInt(full.slice(2,4),16), b=parseInt(full.slice(4,6),16);
  return `${r}, ${g}, ${b}`;
}

function setupColorHelpers(){
  propertiesModal.querySelectorAll('input[type="color"]').forEach(inp => {
    const wrap = document.createElement('div');
    wrap.className = 'color-helper';
    const hex = document.createElement('input');
    hex.type = 'text';
    hex.value = inp.value;
    hex.className = 'color-hex';
    const rgb = document.createElement('span');
    rgb.className = 'color-rgb';
    const sw = document.createElement('span');
    sw.className = 'color-swatch-preview';
    const sync = () => { hex.value = inp.value; rgb.textContent = 'rgb(' + rgbFromHex(inp.value) + ')'; sw.style.background = inp.value; };
    inp.addEventListener('input', sync);
    hex.addEventListener('change', () => { if(/^#?[0-9a-fA-F]{6}$/.test(hex.value)){ inp.value = hex.value.startsWith('#') ? hex.value : '#'+hex.value; sync(); }});
    sync();
    wrap.appendChild(hex); wrap.appendChild(rgb); wrap.appendChild(sw);
    inp.insertAdjacentElement('afterend', wrap);
  });
}

function copyFormat(){
  const flow = getFlow();
  if(selectedNodeIds.size){
    const n = flow.nodes.find(x => selectedNodeIds.has(x.id));
    if(!n) return;
    copiedFormat = {type:'node', data:{color:n.color,textColor:n.textColor,fontFamily:n.fontFamily,fontSize:n.fontSize,textAlign:n.textAlign}};
  } else if(selectedGroupId){
    const g = flow.groups.find(x => x.id === selectedGroupId);
    if(!g) return;
    copiedFormat = {type:'group', data:{color:g.color,opacity:g.opacity,textColor:g.textColor,fontFamily:g.fontFamily,fontSize:g.fontSize,textAlign:g.textAlign}};
  }
}

function pasteFormat(){
  if(!copiedFormat) return;
  const flow = getFlow();
  if(copiedFormat.type==='node' && selectedNodeIds.size){
    flow.nodes.forEach(n => { if(selectedNodeIds.has(n.id)) Object.assign(n, copiedFormat.data); });
  }
  if(copiedFormat.type==='group' && selectedGroupId){
    const g = flow.groups.find(x => x.id===selectedGroupId);
    if(g) Object.assign(g, copiedFormat.data);
  }
  updateMermaid();
  renderScene();
}

function hideMenu(){ contextMenu.style.display = 'none'; }
document.addEventListener('click', hideMenu);


function applyQuickFormatting(useFill=false){
  const flow = getFlow();
  if(selectedNodeIds.size){
    flow.nodes.forEach(node => {
      if(selectedNodeIds.has(node.id)){
        if(!node.lockFont){
          node.fontFamily = quickFontFamily.value || node.fontFamily;
          node.fontSize = Math.max(10, Math.min(48, Number(quickFontSize.value || node.fontSize || 14)));
        }
        node.textColor = quickTextColor.value;
        node.textAlign = quickTextAlign.value || 'center';
        if(useFill) node.color = quickNodeColor.value;
      }
    });
  }
  if(selectedGroupId){
    const g = flow.groups.find(x=>x.id===selectedGroupId);
    if(g){
      g.fontFamily = quickFontFamily.value || g.fontFamily;
      g.fontSize = Number(quickFontSize.value || g.fontSize || 14);
      g.textColor = quickTextColor.value;
      g.textAlign = quickTextAlign.value || 'center';
      if(useFill) g.color = quickGroupColor.value;
    }
  }
  updateMermaid();
  renderScene();
}

function setupQuickBar(){
  toggleQuickBar.onclick = () => {
    quickBarVisible = !quickBarVisible;
    quickBar.classList.toggle('hidden', !quickBarVisible);
  };

  const applyText = () => applyQuickFormatting(false);
  const applyFill = () => applyQuickFormatting(true);

  quickFontFamily.onchange = applyText;
  quickFontSize.oninput = applyText;
  quickTextAlign.onchange = applyText;
  quickTextColor.oninput = applyText;
  quickNodeColor.oninput = applyFill;
  quickGroupColor.oninput = applyFill;

  quickCopyFormat.onclick = copyFormat;
  quickPasteFormat.onclick = pasteFormat;
  quickCreateGroup.onclick = createGroupFromSelection;
  quickRemoveGroup.onclick = () => {
    if(selectedGroupId) deleteSelectedGroup();
  };
}

function applyDocStyleToUI(){
  const flow = getFlow();
  const s = flow.docStyle;
  document.documentElement.style.setProperty('--doc-font-family', s.fontFamily || 'Inter');
  document.documentElement.style.setProperty('--doc-font-size', (s.fontSize || 14) + 'px');
  document.documentElement.style.setProperty('--doc-text-color', s.textColor || '#e8e8e8');
  docFontFamily.value = s.fontFamily || 'Inter';
  docFontSize.value = s.fontSize || 14;
  docTextColor.value = s.textColor || '#e8e8e8';
}

function updateMermaid(){
  const flow = getFlow();
  let out = 'flowchart TD\n';
  flow.nodes.forEach(n => out += `${n.id}["${String(n.label).replace(/"/g,'\\"').replace(/\n/g,'<br/>')}"]\n`);
  flow.links.forEach(l => out += `${l.from} --> ${l.to}\n`);
  mermaidCode.value = out;
  saveLocal();
}

function parseMermaidNode(token){
  const m = token.match(/^([A-Za-z0-9_]+)\s*(?:\[(.*?)\]|\{(.*?)\}|\(\((.*?)\)\)|\((.*?)\))?$/);
  if(!m) return null;
  const label = [m[2],m[3],m[4],m[5],m[1]].find(Boolean);
  return { id: m[1], label: String(label).replace(/^"|"$/g,'').replace(/<br\/>/g,'\n') };
}

function importMermaidFromText(){
  const normalized = mermaidCode.value.replace(/\\n/g, '\n');
  const chunks = [];
  normalized.split(/\r?\n/).forEach(line => {
    line.split(';').map(v => v.trim()).filter(Boolean).forEach(v => chunks.push(v));
  });

  const flow = getFlow();
  flow.nodes = [];
  flow.links = [];
  flow.groups = [];
  const known = new Set();
  let idx = 0;

  const ensureNode = (id, label=id) => {
    if(known.has(id)) return;
    known.add(id);
    flow.nodes.push({id,label,color:'#2f80ed',x:80+(idx%4)*190,y:60+Math.floor(idx/4)*120,fontSize:14,fontFamily:'Inter',textColor:'#ffffff',textAlign:'center'});
    idx++;
  };

  for(const line of chunks){
    if(/^(flowchart|graph)\b/i.test(line)) continue;

    const edge = line.match(/^(.+?)\s*--(?:\|.*?\|)?[^>]*>\s*(.+)$/);
    if(edge){
      const left = parseMermaidNode(edge[1].trim());
      const rightToken = edge[2].trim().replace(/^\|.*?\|\s*/, '');
      const right = parseMermaidNode(rightToken);
      if(left && right){
        ensureNode(left.id, left.label);
        ensureNode(right.id, right.label);
        flow.links.push({id:uid('l'),from:left.id,to:right.id,fromSide:'right',toSide:'left',color:'#222222',width:2,shape:'curve'});
      }
      continue;
    }

    const solo = parseMermaidNode(line);
    if(solo) ensureNode(solo.id, solo.label);
  }

  selectedNodeIds.clear(); selectedLinkId = null; selectedGroupId = null;
  renderScene();
  updateMermaid();
}

function saveLocal(){
  const flow = getFlow();
  flow.notes = notesArea.value;
  flow.tasks = taskArea.value;
  localStorage.setItem('nodemind_state', JSON.stringify({currentFlow, flows:Array.from(flows.entries())}));
}

function loadLocal(){
  try {
    const data = JSON.parse(localStorage.getItem('nodemind_state') || '{}');
    (data.flows || []).forEach(([name,val]) => flows.set(name,val));
    currentFlow = data.currentFlow || currentFlow;
  } catch {}
  const theme = localStorage.getItem('nodemind_theme') || 'dark';
  document.body.classList.toggle('theme-light', theme === 'light');
  themeToggleBtn.textContent = theme === 'light' ? '☀' : '☾';
  if(!flows.size) initFlow(currentFlow);
  renderFlows();
  loadFlowUI();
}

function loadFlowUI(){
  const flow = getFlow();
  notesArea.value = flow.notes || '';
  taskArea.value = flow.tasks || '';
  selectedNodeIds.clear(); selectedGroupId = null; selectedLinkId = null;
  applyDocStyleToUI();
  renderScene();
  updateMermaid();
}

function renderFlows(){
  const bar = document.getElementById('flowsBar');
  bar.querySelectorAll('.flow-tab').forEach(t => t.remove());
  Array.from(flows.keys()).forEach(name => {
    const tab = document.createElement('div');
    tab.className = 'flow-tab' + (name === currentFlow ? ' active' : '');
    tab.innerHTML = `<span class="flow-name">${name}</span>${name === currentFlow ? '<button class="flow-del" title="Elimina flow">×</button>' : ''}`;
    tab.onclick = (e) => {
      if(e.target.classList.contains('flow-del')) return;
      saveLocal();
      currentFlow = name;
      renderFlows();
      loadFlowUI();
    };
    tab.ondblclick = () => {
      const newName = prompt('Rinomina flow:', name);
      if(!newName || newName === name || flows.has(newName)) return;
      const data = flows.get(name);
      flows.delete(name);
      flows.set(newName, data);
      if(currentFlow === name) currentFlow = newName;
      renderFlows();
      saveLocal();
    };
    const delBtn = tab.querySelector('.flow-del');
    if(delBtn){
      delBtn.onclick = (e) => {
        e.stopPropagation();
        if(flows.size <= 1) return alert('Serve almeno un flow.');
        if(!confirm(`Eliminare il flow "${name}"?`)) return;
        flows.delete(name);
        if(currentFlow === name) currentFlow = Array.from(flows.keys())[0];
        renderFlows();
        loadFlowUI();
        saveLocal();
      };
    }
    bar.insertBefore(tab, addFlowBtn);
  });
}

function applyZoom(){ scene.style.transform = `scale(${zoom})`; zoomValue.textContent = Math.round(zoom*100) + '%'; drawLinks(); }

paletteSearch.oninput = renderPalette;
openAll.onclick = () => document.querySelectorAll('.category').forEach(c => c.classList.remove('collapsed'));
closeAll.onclick = () => document.querySelectorAll('.category').forEach(c => c.classList.add('collapsed'));

toggleLeft.onclick = () => { leftPanel.classList.toggle('collapsed-panel'); appGrid.classList.toggle('hidden-left'); };
toggleRight.onclick = () => { rightPanel.classList.toggle('collapsed-panel'); appGrid.classList.toggle('hidden-right'); };

document.querySelectorAll('.tab').forEach(t => t.onclick = () => {
  document.querySelectorAll('.tab').forEach(v => v.classList.remove('active'));
  document.querySelectorAll('.tab-content').forEach(v => v.classList.remove('active'));
  t.classList.add('active');
  document.getElementById('tab-' + t.dataset.tab).classList.add('active');
});

openPropertiesModal.onclick = () => { openPropertiesModalFor('node'); };
closePropertiesModal.onclick = () => { propertiesModal.classList.add('hidden'); };
copyFormatBtn.onclick = copyFormat;
pasteFormatBtn.onclick = pasteFormat;
propertiesModal.addEventListener('click', (e) => { if(e.target === propertiesModal) propertiesModal.classList.add('hidden'); });

const modalHeader = propertiesModal.querySelector('.modal-header');
modalHeader.onmousedown = (e) => {
  if(e.target.closest('button')) return;
  const card = propertiesModal.querySelector('.modal-card');
  const r = card.getBoundingClientRect();
  modalDrag = {dx: e.clientX - r.left, dy: e.clientY - r.top, card};
  card.style.position = 'fixed';
};
document.addEventListener('mousemove', (e) => {
  if(!modalDrag) return;
  modalDrag.card.style.left = (e.clientX - modalDrag.dx) + 'px';
  modalDrag.card.style.top = (e.clientY - modalDrag.dy) + 'px';
});
document.addEventListener('mouseup', () => { modalDrag = null; });

addFlowBtn.onclick = () => {
  const name = prompt('Nome nuovo flow:');
  if(!name) return;
  initFlow(name);
  currentFlow = name;
  renderFlows();
  loadFlowUI();
};

themeToggleBtn.onclick = () => {
  const light = !document.body.classList.contains('theme-light');
  document.body.classList.toggle('theme-light', light);
  themeToggleBtn.textContent = light ? '☀' : '☾';
  localStorage.setItem('nodemind_theme', light ? 'light' : 'dark');
};

document.getElementById('applyMermaid').onclick = importMermaidFromText;
applyNodeStyle.onclick = () => {
  const flow = getFlow();
  if(selectedNodeIds.size){
    flow.nodes.forEach(node => {
      if(selectedNodeIds.has(node.id)){
        if(selectedNodeIds.size === 1) node.label = nodeText.value || node.label;
        node.color = nodeColor.value;
        node.textColor = nodeTextColor.value;
        if(!node.lockFont){
          node.fontFamily = nodeFontFamily.value || 'Inter';
          node.fontSize = Math.max(10, Math.min(48, Number(nodeFontSize.value || 14)));
        }
        node.textAlign = nodeTextAlign.value || 'center';
      }
    });
  }
  if(selectedLinkId){
    const link = flow.links.find(l => l.id === selectedLinkId);
    if(link){ link.color = linkColor.value; link.width = Math.max(1, Math.min(12, Number(linkWidth.value || 2))); link.shape = linkShape.value || 'curve'; }
  }
  updateMermaid();
  renderScene();
};

document.getElementById('sideTextEdit').addEventListener('input', (e) => {
  const flow = getFlow();
  if(selectedNodeIds.size === 1){
    const node = flow.nodes.find(n => selectedNodeIds.has(n.id));
    if(!node) return;
    node.label = e.target.value;
    nodeText.value = node.label;
    updateMermaid();
    renderScene();
    return;
  }
  if(selectedGroupId){
    const group = flow.groups.find(g => g.id === selectedGroupId);
    if(!group) return;
    group.title = e.target.value;
    groupTitle.value = group.title;
    updateMermaid();
    renderScene();
  }
});

document.getElementById('sideCodeEdit').addEventListener('input', (e) => {
  const flow = getFlow();
  const node = flow.nodes.find(n => selectedNodeIds.has(n.id));
  if(!node || node.type !== 'code') return;
  node.label = e.target.value;
  nodeText.value = node.label;
  updateMermaid();
  renderScene();
});

document.getElementById('sideHtmlEdit').addEventListener('input', (e) => {
  const flow = getFlow();
  const node = flow.nodes.find(n => selectedNodeIds.has(n.id));
  if(!node || node.type !== 'html') return;
  node.label = e.target.value;
  nodeText.value = node.label;
  updateMermaid();
  renderScene();
});

document.getElementById('sideEmojiEdit').addEventListener('input', (e) => {
  const flow = getFlow();
  const node = flow.nodes.find(n => selectedNodeIds.has(n.id));
  if(!node || node.type !== 'emoji') return;
  node.label = e.target.value || '😀';
  nodeText.value = node.label;
  updateMermaid();
  renderScene();
});

document.getElementById('sideOperatorEdit').addEventListener('change', (e) => {
  const flow = getFlow();
  const node = flow.nodes.find(n => selectedNodeIds.has(n.id));
  if(!node || node.type !== 'connector') return;
  node.operator = e.target.value;
  node.label = e.target.value;
  nodeText.value = node.label;
  updateMermaid();
  renderScene();
});

const applySideLinkProps = () => {
  if(!selectedLinkId) return;
  const flow = getFlow();
  const link = flow.links.find(l => l.id === selectedLinkId);
  if(!link) return;
  link.color = document.getElementById('sideLinkColor').value;
  link.width = Math.max(1, Math.min(12, Number(document.getElementById('sideLinkWidth').value || 2)));
  link.shape = document.getElementById('sideLinkShape').value || 'curve';
  linkColor.value = link.color;
  linkWidth.value = String(link.width);
  linkShape.value = link.shape;
  updateMermaid();
  renderScene();
};
document.getElementById('sideLinkColor').addEventListener('input', applySideLinkProps);
document.getElementById('sideLinkWidth').addEventListener('input', applySideLinkProps);
document.getElementById('sideLinkShape').addEventListener('change', applySideLinkProps);

deleteSelectedLink.onclick = deleteSelectedLinkFn;
createGroupBtn.onclick = createGroupFromSelection;
applyGroupStyle.onclick = applyGroupStyleFn;
applyDocStyle.onclick = () => {
  const flow = getFlow();
  flow.docStyle = {fontFamily: docFontFamily.value || 'Inter', fontSize: Number(docFontSize.value || 14), textColor: docTextColor.value};
  applyDocStyleToUI();
  saveLocal();
};

zoomIn.onclick = () => { zoom = Math.min(2.5, zoom + 0.1); applyZoom(); };
zoomOut.onclick = () => { zoom = Math.max(0.4, zoom - 0.1); applyZoom(); };
zoomReset.onclick = () => { zoom = 1; applyZoom(); };

saveBtn.onclick = () => { saveLocal(); alert('Salvato in locale'); };
exportBtn.onclick = () => {
  saveLocal();
  const blob = new Blob([JSON.stringify({currentFlow, flows:Array.from(flows.entries())}, null, 2)], {type:'application/json'});
  const a = document.createElement('a');
  a.href = URL.createObjectURL(blob);
  a.download = 'nodemind-studio-export.json';
  a.click();
  URL.revokeObjectURL(a.href);
};

importBtn.onclick = () => fileInput.click();
fileInput.onchange = (e) => {
  const file = e.target.files[0];
  if(!file) return;
  const reader = new FileReader();
  reader.onload = () => {
    const text = String(reader.result || '');
    if(file.name.endsWith('.json')){
      try {
        const payload = JSON.parse(text);
        flows.clear();
        (payload.flows || []).forEach(([n,v]) => flows.set(n,v));
        currentFlow = payload.currentFlow || 'Flow 1';
        renderFlows();
        loadFlowUI();
      } catch { alert('JSON non valido'); }
    } else {
      mermaidCode.value = text;
      importMermaidFromText();
    }
  };
  reader.readAsText(file);
};

scene.addEventListener('dragover', e => e.preventDefault());
scene.addEventListener('drop', e => {
  e.preventDefault();
  const rect = scene.getBoundingClientRect();
  let item = {name:'Nodo', color:'#2f80ed', type:'default'};
  try { item = JSON.parse(e.dataTransfer.getData('application/json')); } catch {}
  addNode({label:item.name,color:item.color,x:(e.clientX-rect.left)/zoom,y:(e.clientY-rect.top)/zoom,fontFamily:'Inter',textColor:'#fff',textAlign:'center',type:item.type || 'default'});
});

notesArea.addEventListener('input', saveLocal);
taskArea.addEventListener('input', saveLocal);

linkLayer.addEventListener('click', (e) => {
  if(e.target && e.target.tagName && e.target.tagName.toLowerCase() === 'path'){
    const id = e.target.getAttribute('data-link-id');
    const flow = getFlow();
    const l = flow.links.find(v => v.id === id);
    if(l){
      selectedLinkId = l.id;
      selectedNodeIds.clear();
      selectedGroupId = null;
      setPropertiesMode('link');
      linkColor.value = l.color || '#222222';
      linkWidth.value = String(l.width || 2);
      linkShape.value = l.shape || 'curve';
      renderScene();
      return;
    }
  }
  const rect = scene.getBoundingClientRect();
  const x = (e.clientX - rect.left) / zoom;
  const y = (e.clientY - rect.top) / zoom;
  const flow = getFlow();
  let best = null;
  let bestDist = Infinity;
  flow.links.forEach(l => {
    const d = linkDistanceToPoint(l, x, y);
    if(d < bestDist){ bestDist = d; best = l; }
  });
  if(best && bestDist <= 18){
    selectedLinkId = best.id;
    selectedNodeIds.clear();
    selectedGroupId = null;
    setPropertiesMode('link');
    linkColor.value = best.color || '#222222';
    linkWidth.value = String(best.width || 2);
    linkShape.value = best.shape || 'curve';
    renderScene();
    return;
  }
  selectedNodeIds.clear(); selectedGroupId = null; selectedLinkId = null; setPropertiesMode('all'); renderScene();
});

scene.addEventListener('click', (e) => {
  if(e.target.closest('.node') || e.target.closest('.node-group') || e.target.classList.contains('port')) return;
  const rect = scene.getBoundingClientRect();
  const x = (e.clientX - rect.left) / zoom;
  const y = (e.clientY - rect.top) / zoom;
  const flow = getFlow();
  let best = null;
  let bestDist = Infinity;
  flow.links.forEach(l => {
    const d = linkDistanceToPoint(l, x, y);
    if(d < bestDist){ bestDist = d; best = l; }
  });
  if(best && bestDist <= 18){
    selectedLinkId = best.id;
    selectedNodeIds.clear();
    selectedGroupId = null;
    setPropertiesMode('link');
    linkColor.value = best.color || '#222222';
    linkWidth.value = String(best.width || 2);
    linkShape.value = best.shape || 'curve';
    renderScene();
  }
});

centerPanel.addEventListener('pointerdown', (e) => {
  if(e.button !== 0) return;
  if(e.target.closest('.node') || e.target.closest('.node-group') || e.target.classList.contains('port')) return;
  const rect = scene.getBoundingClientRect();
  const x = (e.clientX - rect.left) / zoom;
  const y = (e.clientY - rect.top) / zoom;
  const flow = getFlow();
  let best = null;
  let bestDist = Infinity;
  flow.links.forEach(l => {
    const d = linkDistanceToPoint(l, x, y);
    if(d < bestDist){ bestDist = d; best = l; }
  });
  if(best && bestDist <= 22){
    selectedLinkId = best.id;
    selectedNodeIds.clear();
    selectedGroupId = null;
    setPropertiesMode('link');
    linkColor.value = best.color || '#222222';
    linkWidth.value = String(best.width || 2);
    linkShape.value = best.shape || 'curve';
    renderScene();
    e.preventDefault();
    e.stopPropagation();
  }
}, true);

document.addEventListener('keydown', (e) => {
  const activeTag = (document.activeElement?.tagName || '').toLowerCase();
  const inTextInput = ['textarea','input'].includes(activeTag) || document.activeElement?.isContentEditable;
  if((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'c' && !inTextInput){ e.preventDefault(); copySelectedNodes(); }
  if((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'v' && !inTextInput){ e.preventDefault(); pasteNodes(); }
  if((e.key === 'Delete' || e.key === 'Backspace') && !inTextInput){
    e.preventDefault();
    if(selectedLinkId) deleteSelectedLinkFn();
    else if(selectedGroupId) deleteSelectedGroup();
    else if(selectedNodeIds.size) deleteNodes(Array.from(selectedNodeIds));
  }
});

initFlow(currentFlow);
renderPalette();
setupColorHelpers();
setupQuickBar();
setPropertiesMode('all');
loadLocal();
</script>
</body>
</html>
